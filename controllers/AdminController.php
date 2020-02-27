<?php

namespace app\controllers;

use app\auth\Item;
use app\models\County;
use app\models\Region;
use app\models\search\CountySearch;
use app\models\search\RegionSearch;
use app\models\User;
use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

class AdminController extends \app\core\WebController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Item::ROLE_ADMIN],
                    ]
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays the admin dashboard
     *
     * @return string
     */
    public function actionIndex(): Response
    {
        $regionFilterModel = new RegionSearch;
        $regionDataProvider = $regionFilterModel->search($this->request->queryParams);

        $countyFilterModel = new CountySearch;
        $countyDataProvider = $countyFilterModel->search($this->request->queryParams);

        return $this->createResponse(
            'index',
            compact(
                'regionFilterModel',
                'regionDataProvider',
                'countyFilterModel',
                'countyDataProvider'
            )
        );
    }

    /**
     * Action for an existing admin to create another admin
     */
    public function actionAdminCreate(): Response
    {
        $user = new User([
            'status' => User::STATUS_UNVERIFIED,
            'roles' => [Item::ROLE_ADMIN],
            'password' => Yii::$app->security->generateRandomString(12),
            'password_reset_token' => Yii::$app->security->generateRandomString()
        ]);

        $user->generateAuthKey();
        
        if ($this->request->isPost) {
            $user->load($this->request->post());

            if ($user->save() && $user->validate()) {
                Yii::$app->session->addFlash('success', 'Admin successfully created');
                Yii::$app->mailer->compose('admin-email-confirm', ['user' => $user])
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo([$user->email => $user->username])
                    ->setSubject('Welcome to '.Yii::$app->name)
                    ->send();
                return $this->redirect('/admin');
            }
        }

        return $this->createResponse('create-admin', compact('user'));
    }

    public function actionAddRegion(): Response
    {
        $region = new Region;
        $edit = false;

        if ($this->request->isPost) {
            $region->load($this->request->post());
            
            if ($region->save() && $region->validate()) {
                Yii::$app->session->addFlash('success', 'Region successfully created');
                return $this->redirect('/admin');
            }
        }

        return $this->createResponse('edit-region', compact('region', 'edit'));
    }

    public function actionEditRegion(int $region_id): Response
    {
        $region = Region::findOne($region_id);
        $edit = true;

        if ($region === null) {
            throw new BadRequestHttpException('Invalid Request');
        }

        if ($this->request->isPost) {
            $region->load($this->request->post());

            if ($region->save() && $region->validate()) {
                Yii::$app->session->addFlash('success', 'Region successfully updated');
                return $this->redirect('/admin');
            }
        }

        return $this->createResponse('edit-region', compact('region', 'edit'));
    }

    public function actionAddCounty(): Response
    {
        $county = new County;
        $edit = false;

        if ($this->request->isPost) {
            $county->load($this->request->post());
            
            if ($county->save() && $county->validate()) {
                Yii::$app->session->addFlash('success', 'County successfully created');
                return $this->redirect('/admin');
            }
        }

        return $this->createResponse('edit-county', compact('county', 'edit'));
    }

    public function actionEditCounty(int $county_id): Response
    {
        $county = County::findOne($county_id);
        $edit = true;

        if ($county === null) {
            throw new BadRequestHttpException('Invalid Request');
        }

        if ($this->request->isPost) {
            $county->load($this->request->post());

            if ($county->save() && $county->validate()) {
                Yii::$app->session->addFlash('success', 'County successfully updated');
                return $this->redirect('/admin');
            }
        }

        return $this->createResponse('edit-county', compact('county', 'edit'));
    }

}

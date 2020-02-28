<?php

namespace app\controllers;

use app\auth\Item;
use app\models\Artist;
use app\models\County;
use app\models\Region;
use app\models\search\ArtistSearch;
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
     * @return Response
     */
    public function actionIndex(): Response
    {
        return $this->createResponse('index');
    }

    /**
     * Display the locations page for the admin dashboard
     * 
     * @return Response
     */
    public function actionLocations(): Response
    {
        $regionFilterModel = new RegionSearch;
        $regionDataProvider = $regionFilterModel->search($this->request->queryParams);

        $countyFilterModel = new CountySearch;
        $countyDataProvider = $countyFilterModel->search($this->request->queryParams);

        return $this->createResponse(
            'locations',
            compact(
                'regionFilterModel',
                'regionDataProvider',
                'countyFilterModel',
                'countyDataProvider'
            )
        );
    }

    /**
     * Action to load the main page for artist management
     * 
     * @return Response
     */
    public function actionArtist(): Response
    {
        $artistFilterModel = new ArtistSearch;
        $artistDataProvider = $artistFilterModel->search($this->request->queryParams);

        return $this->createResponse(
            'artists',
            compact(
                'artistFilterModel',
                'artistDataProvider'
            )
        );
    }

    /**
     * Creates a new artist page
     * 
     * @return Response
     */
    public function actionAddArtist(): Response
    {
        $artist = new Artist([
            'status' => Artist::STATUS_ACTIVE
        ]);

        if ($this->request->isPost) {
            $artist->load($this->request->post());

            if ($artist->save() && $artist->validate()) {
                Yii::$app->session->addFlash('success', 'Artist page successfully created');
                return $this->redirect(['/artist/view', 'artist_id' => $artist->artist_id]);
            }
        }

        return $this->createResponse('create-artist', compact('artist'));
    }

    /**
     * Action for an existing admin to create another admin
     * 
     * @return Response
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

    /**
     * Action for adding a new Region
     * 
     * @return Response
     */
    public function actionAddRegion(): Response
    {
        $region = new Region;
        $edit = false;

        if ($this->request->isPost) {
            $region->load($this->request->post());
            
            if ($region->save() && $region->validate()) {
                Yii::$app->session->addFlash('success', 'Region successfully created');
                return $this->redirect('/admin/locations');
            }
        }

        return $this->createResponse('edit-region', compact('region', 'edit'));
    }

    /**
     * Action for editing and existing Region
     * 
     * @return Response
     */
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
                return $this->redirect('/admin/locations');
            }
        }

        return $this->createResponse('edit-region', compact('region', 'edit'));
    }

    /**
     * Action for creating a new County
     * 
     * @return Response
     */
    public function actionAddCounty(): Response
    {
        $county = new County;
        $edit = false;

        if ($this->request->isPost) {
            $county->load($this->request->post());
            
            if ($county->save() && $county->validate()) {
                Yii::$app->session->addFlash('success', 'County successfully created');
                return $this->redirect('/admin/locations');
            }
        }

        return $this->createResponse('edit-county', compact('county', 'edit'));
    }

    /**
     * Action for editing an existing county
     * 
     * @return Response
     */
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
                return $this->redirect('/admin/locations');
            }
        }

        return $this->createResponse('edit-county', compact('county', 'edit'));
    }

}

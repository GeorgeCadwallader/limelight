<?php

namespace app\controllers;

use app\auth\Item;
use app\models\Artist;
use app\models\ReviewArtist;
use app\models\ReviewVenue;
use app\models\UserVote;

use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

class ReviewController extends \app\core\WebController
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
                        'actions' => [
                            'upvote',
                            'downvote',
                            'create-artist'
                        ],
                        'roles' => [Item::ROLE_MEMBER],
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
     * Action for upvoting an artist or venue review
     * 
     * @return Response
     */
    public function actionUpvote(int $review_id, bool $isArtist): Response
    {
        if ($isArtist) {
            $review = ReviewArtist::findOne($review_id);

            if ($review === null) {
                throw new BadRequestHttpException('Invalid Review');
            }
            
            $query = UserVote::find()
                ->where([
                    'AND',
                    ['review_artist_id' => $review->artist_id],
                    ['created_by' => Yii::$app->user->id]
                ]);
            
            if ($query->exists()) {
                $vote = $query->one();

                if ($vote->type === UserVote::TYPE_DOWNVOTE) {
                    $review->downvotes -= 1;
                    $review->upvotes += 1;
                    $vote->type = UserVote::TYPE_UPVOTE;

                    if ($vote->save() && $review->save()) {
                        return $this->redirect(['/artist/view', 'artist_id' => $review->artist->artist_id]);
                    }
                }

                return $this->redirect(['/artist/view', 'artist_id' => $review->artist->artist_id]);
            }

            $vote = new UserVote([
                'type' => UserVote::TYPE_UPVOTE,
            ]);
            $vote->link('reviewArtist', $review);
            $review->upvotes += 1;

            if ($vote->save() && $review->save()) {
                return $this->redirect(['/artist/view', 'artist_id' => $review->artist->artist_id]);
            }
        } else {
            $review = ReviewVenue::findOne($review_id);

            if ($review === null) {
                throw new BadRequestHttpException('Invalid Review');
            }
            
            $query = UserVote::find()
                ->where(
                    'AND',
                    ['review_venue_id' => $review->venue_id],
                    ['created_by' => Yii::$app->user->id]
                );
            
            if ($query->exists()) {
                $vote = $query->one();

                if ($vote->type === UserVote::TYPE_DOWNVOTE) {
                    $review->updateCounters(
                        [
                            'downvotes' => -1,
                            'upvotes' => 1
                        ]
                    );
                    $review->downvotes -= 1;
                    $review->upvotes += 1;
                    $vote->type = UserVote::TYPE_UPVOTE;

                    if ($vote->save() && $review->save()) {
                        return $this->redirect(['/venue/view', 'venue_id' => $review->venue->venue_id]);
                    }
                }

                return $this->redirect(['/venue/view', 'venue_id' => $review->venue->venue_id]);
            }

            $vote = new UserVote([
                'type' => UserVote::TYPE_UPVOTE,
            ]);
            $vote->link('reviewVenue', $review);
            $review->upvotes += 1;

            if ($vote->save() && $review->save()) {
                return $this->redirect(['/venue/view', 'venue_id' => $review->venue->venue_id]);
            }
        }
    }

    /**
     * Action for downvoting an artist or venue review
     * 
     * @return Response
     */
    public function actionDownvote(int $review_id, bool $isArtist): Response
    {
        if ($isArtist) {
            $review = ReviewArtist::findOne($review_id);

            if ($review === null) {
                throw new BadRequestHttpException('Invalid Review');
            }
            
            $query = UserVote::find()
                ->where([
                    'AND',
                    ['review_artist_id' => $review->artist_id],
                    ['created_by' => Yii::$app->user->id]
                ]);
            
            if ($query->exists()) {
                $vote = $query->one();

                if ($vote->type === UserVote::TYPE_UPVOTE) {
                    $review->downvotes += 1;
                    $review->upvotes -= 1;
                    $vote->type = UserVote::TYPE_DOWNVOTE;

                    if ($vote->save() && $review->save()) {
                        return $this->redirect(['/artist/view', 'artist_id' => $review->artist->artist_id]);
                    }
                }

                return $this->redirect(['/artist/view', 'artist_id' => $review->artist->artist_id]);
            }

            $vote = new UserVote([
                'type' => UserVote::TYPE_DOWNVOTE,
            ]);
            $vote->link('reviewArtist', $review);
            $review->downvotes += 1;

            if ($vote->save() && $review->save()) {
                return $this->redirect(['/artist/view', 'artist_id' => $review->artist->artist_id]);
            }
        } else {
            $review = ReviewVenue::findOne($review_id);

            if ($review === null) {
                throw new BadRequestHttpException('Invalid Review');
            }
            
            $query = UserVote::find()
                ->where([
                    'AND',
                    ['review_venue_id' => $review->venue_id],
                    ['created_by' => Yii::$app->user->id]
                ]);
            
            if ($query->exists()) {
                $vote = $query->one();

                if ($vote->type === UserVote::TYPE_UPVOTE) {
                    $review->downvotes += 1;
                    $review->upvotes -= 1;

                    $vote->type = UserVote::TYPE_DOWNVOTE;

                    if ($vote->save() && $review->save()) {
                        return $this->redirect(['/venue/view', 'venue_id' => $review->venue->venue_id]);
                    }
                }

                return $this->redirect(['/venue/view', 'venue_id' => $review->venue->venue_id]);
            }

            $vote = new UserVote([
                'type' => UserVote::TYPE_DOWNVOTE,
            ]);
            $vote->link('reviewVenue', $review);
            $review->downvotes += 1;

            if ($vote->save() && $review->save()) {
                return $this->redirect(['/venue/view', 'venue_id' => $review->venue->venue_id]);
            }
        }
    }

}

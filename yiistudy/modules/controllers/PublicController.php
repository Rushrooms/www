<?php
namespace app\modules\controllers;

use yii\web\Controller;
use app\modules\models\Admin;//载入
use Yii;

class PublicController extends Controller
{
    public function actionLogin()
    {
        $this->layout = false;
        $model = new Admin;//实例化
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->login($post)) {
                $this->redirect(['default/index']);
                Yii::$app->end();
            }
        }
        return $this->render("login", ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->session->removeAll();//消除session
        if (!isset(Yii::$app->session['admin']['isLogin'])) { //如果islogin已经不存在了
            $this->redirect(['public/login']); //跳转
            Yii::$app->end();
        }
        $this->goback();//否则跳回到原来页面
    }

    public function actionSeekpassword()
    {
        $this->layout = false;//关闭原布局
        $model = new Admin;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->seekPass($post)) {//发送电子邮件操作   暂时不存在
                //
                Yii::$app->session->setFlash('info', '电子邮件已经发送成功，请查收');
            }
        }
        return $this->render("seekpassword", ['model' => $model]);
    }



}

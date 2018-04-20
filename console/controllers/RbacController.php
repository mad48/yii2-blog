<?php

namespace console\controllers;

use yii;
use yii\console\Controller;

/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); 

        // Создадим роли и  запишем их в БД
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);

        $editor = $auth->createRole('editor');
        $editor->description = 'Редактор';
        $auth->add($editor);

        $author = $auth->createRole('author');
        $author->description = 'Автор';
        $auth->add($author);

        $blocked = $auth->createRole('blocked');
        $blocked->description = 'Заблокированный';
        $auth->add($blocked);


        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование поста updatePost
        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'Просмотр админки';
        $auth->add($viewAdminPage);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Редактирование постов';
        $auth->add($updatePost);


        // Создаем наше правило, которое позволит проверить автора поста
        $authorRule = new \common\rbac\AuthorRule;
        $auth->add($authorRule);
        // add the "updateOwnPost" permission and associate the rule with it.
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Редактирование собственных постов';
        $updateOwnPost->ruleName = $authorRule->name;
        $auth->add($updateOwnPost);

        // "updateOwnPost" will be used from "updatePost"
        $auth->addChild($updateOwnPost, $updatePost);


        
        // Роли «Автор» присваиваем разрешение «Редактирование собственных постов»
        $auth->addChild($author, $updateOwnPost);

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование постов»
        $auth->addChild($editor, $updatePost);

        // админ имеет собственное разрешение - «Редактирование поста»
        $auth->addChild($admin, $updatePost);

        // Еще админ имеет собственное разрешение - «Просмотр админки»
        $auth->addChild($admin, $viewAdminPage);


        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);

        // Назначаем роль editor пользователю с ID 2
        $auth->assign($editor, 2);

        // Назначаем роль editor пользователю с ID 3
        $auth->assign($author, 3);

        // Назначаем роль editor пользователю с ID 4
        $auth->assign($author, 4);
    }
}


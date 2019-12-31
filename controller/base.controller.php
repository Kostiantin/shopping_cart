<?php
abstract class BaseController {

    protected function RenderPage ($pageName, $layoutPath, $viewPath, $model = null) {
        $PAGE = $pageName;
        $MODEL = $model;
        ob_start();
        include $viewPath;
        $MASTER_CONTENT = ob_get_clean();
        require_once $layoutPath;
    }

    protected function RenderView ($viewPath, $model = null) {
        ob_start();
        require_once $viewPath;
        $VIEW_CONTENT = ob_get_clean();
        echo $VIEW_CONTENT;
        die;
    }

    protected function RedirectToController ($controller, $action = null) {
        if ($action == NULL) {
          header('Location: ?c='.$controller);
        } else {
          header('Location: ?c='.$controller.'&a='.$action);
        }
        die();
    }

    protected function RenderJson ($model) {
        header('Content-type: application/json');
        $json = json_encode($model);
        echo $json;
    }

}

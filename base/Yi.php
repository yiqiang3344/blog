<?php
/**
 * Created by PhpStorm.
 * User: sidney
 * Date: 2019/9/12
 * Time: 1:42 PM
 */

namespace base;


use cebe\markdown\GithubMarkdown;

class Yi
{
    private $title = 'sidney的博客';
    private $jsScripts = [];
    private $cssStyle = [];

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionList()
    {
        $this->cssStyle = [
            'base.css',
            'han.css',
        ];
        $dir = __DIR__ . '/../markdown';
        $files = $this->_scandir($dir);
        $list = [];
        foreach ($files as $filename) {
            $list[] = [
                'title' => str_replace('.md', '', basename($filename)),
                'url' => 'view/' . urlencode(str_replace([$dir . '/', '.md'], '', $filename)),
                'created_time' => date('Y-m-d', filectime($filename)),
            ];
        }
        $this->render(['list' => $list,], 'list');
    }

    private function _scandir($dir)
    {
        $ret = [];
        if (!is_dir($dir)) {
            return $ret;
        }
        $list = scandir($dir);
        foreach ($list as $name) {
            if ($name == '..' || $name == '.') {
                continue;
            }
            if (is_dir($dir . '/' . $name)) {
                $ret = array_merge($ret, $this->_scandir($dir . '/' . $name));
                continue;
            }
            $ret[] = $dir . '/' . $name;
        }
        return $ret;
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionView($blog)
    {
        $this->cssStyle = [
            'bootstrap.css',
            'base.css',
            'han.css',
        ];
        $file = __DIR__ . '/../markdown' . '/' . $blog . '.md';
        if (!is_file($file)) {
            die('page not found');
        }
        $markdown = file_get_contents($file);
        $data = [
            'title' => str_replace('.md', '', basename($file)),
            'content' => $markdown,
            'created_time' => date('Y-m-d H:i:s', filectime($file)),
        ];
        $this->_viewByJs($data);
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    private function _viewByPhp($data)
    {
        $parser = new GithubMarkdown();
        $data['content'] = $parser->parse($data['content']);
        $this->render($data, 'view');
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    private function _viewByJs($data)
    {
        $data['content'] = json_encode($data['content']);
        $this->render($data, 'view_js');
    }

    /**
     * @param $data
     * @param $view
     * @param string $layout
     * @throws \Exception
     * @throws \Throwable
     */
    private function render($data, $view, $layout = 'main')
    {
        $cssStyle = '';
        $jsScript = '';
        foreach ($this->jsScripts as $js) {
            $jsScript .= '<script src="/js/' . $js . '"></script>' . PHP_EOL;
        }
        foreach ($this->cssStyle as $css) {
            $cssStyle .= '<link rel="stylesheet" href="/css/' . $css . '">' . PHP_EOL;
        }

        $viewObj = new View($data);
        $viewString = $viewObj->render(__DIR__ . '/../view/' . $view . '.php');

        $view = new View([
            'title' => $data['title'] ?? $this->title,
            'content' => $viewString,
            'jsScript' => $jsScript,
            'cssStyle' => $cssStyle,
        ]);
        echo $view->render(__DIR__ . '/../view/layout/' . $layout . '.php');
    }
}
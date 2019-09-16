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
        $category = $_GET['c'] ?? '';

        $this->cssStyle = [
            'bootstrap.css',
            'markdown.css',
            'han.css',
        ];
        $baseDir = $this->_getMarkdownPath();
        $dir = $category ? $baseDir . '/' . $category : $baseDir;
        $files = $this->_scandir($dir);
        $list = [];
        $tags = [];
        foreach ($files as $filename) {
            $relativeName = str_replace([$baseDir . '/', '.md'], '', $filename);
            $_arr = explode('/', $relativeName);
            if (count($_arr) > 1 && $_arr[0] != $category) {
                $tags[] = [
                    'url' => '/list?c=' . $_arr[0],
                    'name' => $_arr[0],
                ];
            }
            $list[] = [
                'title' => str_replace('.md', '', basename($filename)),
                'url' => 'view/' . urlencode($relativeName),
                'created_time' => date('Y-m-d H:i:s', filectime($filename)),
            ];
        }

        $this->_render([
            'list' => $list,
            'tags' => $tags,
        ], 'list');
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionView($blog)
    {
        $this->cssStyle = [
            'bootstrap.css',
            'markdown.css',
            'han.css',
        ];
        $file = $this->_getMarkdownPath() . '/' . $blog . '.md';
        if (!is_file($file)) {
            die('page not found');
        }
        $markdown = file_get_contents($file);
        preg_match_all('/\(http\:\/\/statics\.blog\.sidneyyi\.com\/(.*)\)/u', $markdown, $matches);
        $_replaces = [];
        foreach ($matches[0] as $k => $_match) {
            if (isset($_replaces[md5($_match)])) {
                continue;
            }
            $_replaces[md5($_match)] = [
                'from' => $_match,
                'to' => '(' . $this->getOss()->getUrl(urldecode($matches[1][$k])) . ')',
            ];
        }
        $markdown = str_replace(array_column($_replaces, 'from'), array_column($_replaces, 'to'), $markdown);
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
    public function actionUpload()
    {
        $key = 'agnese';
        if (empty($_GET['k']) || $_GET['k'] != $key) {
            die('page not found~');
        }

        if (!empty($_FILES['file'])) {
            $category = $_POST['category'] ?? '';
            $dir = $category ? $this->_getMarkdownPath() . '/' . $category : $this->_getMarkdownPath();
            if (!is_dir($dir)) {
                if (!mkdir($dir, 0775, true)) {
                    die('mkdir failed');
                }
            }

            $ret = move_uploaded_file($_FILES['file']['tmp_name'], $dir . '/' . $_FILES['file']['name']);
            if ($ret === false) {
                die('上传失败');
            }
            $this->_redirect('/list');
            return;
        }

        $this->cssStyle = [
            'bootstrap.css',
        ];
        $this->_render([
            'key' => $key,
        ], 'upload');
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    private function _viewByPhp($data)
    {
        $parser = new GithubMarkdown();
        $data['content'] = $parser->parse($data['content']);
        $this->_render($data, 'view');
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    private function _viewByJs($data)
    {
        $data['content'] = json_encode($data['content']);
        $this->_render($data, 'view_js');
    }

    /**
     * @param $data
     * @param $view
     * @param string $layout
     * @throws \Exception
     * @throws \Throwable
     */
    private function _render($data, $view, $layout = 'main')
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

    /**
     * @param int $code
     * @param string $message
     * @param array $data
     */
    private function _renderJson($code = 1, $message = '请求成功', $data = [])
    {
        echo json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * @param $url
     */
    private function _redirect($url)
    {
        header("Location: $url");
        exit();
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
     * @return string
     */
    private function _getMarkdownPath()
    {
        return __DIR__ . '/../web/markdown';
    }

    /**
     * @return Oss
     */
    private function getOss()
    {
        $config = [
            'accessKeyId' => 'LTAI4FbcuPQEy6r7r4ZPcgQA',
            'accessKeySecret' => 'DfOa8kCi6pMNO4q6nPNkYwjOvgOQ4e',
            'endpoint' => 'https://yjq-blog.oss-cn-hangzhou.aliyuncs.com',
            'domain' => 'http://statics.blog.sidneyyi.com',
            'securityToken' => null,
            'timeout' => 3600,
            'bucket' => 'yjq-blog',
        ];
        return Oss::getInstance($config['bucket'], $config);
    }
}
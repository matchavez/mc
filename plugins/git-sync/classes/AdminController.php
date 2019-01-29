<?php

namespace Grav\Plugin\GitSync;

use Grav\Common\Grav;
use Grav\Common\Plugin;
use Grav\Common\Utils;
use Grav\Plugin\Admin\AdminBaseController;

class AdminController extends AdminBaseController
{
    protected $action;
    protected $target;
    protected $active;
    protected $plugin;
    protected $task_prefix = 'task';
    public $git;

    /**
     * @param Plugin   $plugin
     */
    public function __construct(Plugin $plugin)
    {
        $post = !empty($_POST) ? $_POST : [];
        $this->grav = Grav::instance();
        $this->active = false;
        $uri = $this->grav['uri'];
        $this->post = $this->getPost($post);
        $this->plugin = $plugin;

        // Ensure the controller should be running
        if (Utils::isAdminPlugin()) {
            $routeDetails = $this->grav['admin']->getRouteDetails();
            $target = array_pop($routeDetails);
            $this->git = new GitSync($plugin);

            // return null if this is not running
            if ($target != $plugin->name)  {
                return;
            }

            $this->action = !empty($this->post['action']) ? $this->post['action'] : $uri->param('action');
            $this->target = $target;
            $this->active = true;
            $this->admin = Grav::instance()['admin'];

            $task = !empty($post['task']) ? $post['task'] : $uri->param('task');
            if ($task && ($this->target == $plugin->name || $uri->route() == '/lessons')) {
                $this->task = $task;
                $this->active = true;
            }
        }
    }

    public function taskTestConnection()
    {
        $post    = $this->post;
        $data    = json_decode(base64_decode($post['test']));

        try {
            Helper::testRepository($data->user, $data->password, $data->repository);
            echo json_encode([
                'status'  => "success",
                'message' => 'The connection to the repository has been successful.'
            ]);
        } catch (\Exception $e) {
            $invalid = str_replace($data->password, '{password}', $e->getMessage());
            echo json_encode([
                'status'  => "error",
                'message' => $invalid
            ]);
        }

        exit;
    }

    public function taskSynchronize()
    {
        try {
            $this->plugin->synchronize();
            echo json_encode([
                'status'  => "success",
                'message' => 'GitSync has successfully synchronized with the repository.'
            ]);
        } catch (\Exception $e) {
            $invalid = str_replace($this->git->getConfig('password', null), '{password}', $e->getMessage());
            echo json_encode([
                'status'  => "error",
                'message' => $invalid
            ]);
        }

        exit;
    }

    public function taskResetLocal()
    {
        try {
            $this->plugin->reset();
            echo json_encode([
                'status'  => "success",
                'message' => 'GitSync has successfully reset your local changes and synchronized with the repository.'
            ]);
        } catch (\Exception $e) {
            $invalid = str_replace($this->git->getConfig('password', null), '{password}', $e->getMessage());
            echo json_encode([
                'status'  => "error",
                'message' => $invalid
            ]);
        }

        exit;
    }

    /**
     * Performs a task or action on a post or target.
     *
     * @return bool|mixed
     */
    public function execute()
    {
        $success = false;
        $params = [];

        // Handle Task & Action
        if ($this->post && $this->task) {
            // validate nonce
            if (!$this->validateNonce()) {
                return false;
            }
            $method = $this->task_prefix . ucfirst($this->task);
        } elseif ($this->target) {
            if (!$this->action) {
                return false;
            }
            $method = strtolower($this->action) . ucfirst($this->target);
        } else {
            return false;
        }

        if (!method_exists($this, $method)) {
            return false;
        }

        $success = call_user_func_array([$this, $method], $params);

        // Grab redirect parameter.
        $redirect = isset($this->post['_redirect']) ? $this->post['_redirect'] : null;
        unset($this->post['_redirect']);

        // Redirect if requested.
        if ($redirect) {
            $this->setRedirect($redirect);
        }

        return $success;
    }

    public function isActive()
    {
        return (bool) $this->active;
    }
}

<?php

declare(strict_types=1);

namespace app\core;

class Application
{
    public static Application $app;
    private Request $request;
    private Response $response;
    private Router $router;
    private Logger $logger;
    private Database $database;
    private ?\app\models\AuthUser $user = null;

    public function __construct()
    {
        self::$app = $this;
        session_start();
        $this->logger = new Logger(sprintf("%sruntime/%s", PROJECT_ROOT, $_ENV["APP_LOG"]));
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->database = new Database(getenv("DB_DSN"), getenv("DB_USER"), getenv("DB_PASSWORD"));

        if (isset($_SESSION['user_id'])) {
            $mapper = new \app\mappers\AuthMapper();
            $this->user = $mapper->Select((int)$_SESSION['user_id']);
        }

    }

    public function run()
    {

        try {
            $this->router->resolve();
        } catch (\Exception $exception) {
            $this->getLogger()->error("Cannot resolve route: $exception");
            $this->response->setStatusCode(HttpStatusCodeEnum::HTTP_SERVER_ERROR);
        }
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /**
     * @return Database
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }

    public function login(\app\models\AuthUser $user): void
    {
        $_SESSION['user_id'] = $user->getId();
        $this->user = $user;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        $this->user = null;
    }

    public function getUser(): ?\app\models\AuthUser
    {
        return $this->user;
    }
}
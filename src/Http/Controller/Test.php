<?php

    namespace Coco\moduleTest\Http\Controller;

    use Coco\cocoApp\Kernel\Business\ControllerWrapper\WebControllerWrapper;
    use Coco\session\SessionManager;
    use Dflydev\FigCookies\Cookie;
    use Dflydev\FigCookies\Cookies;
    use Dflydev\FigCookies\FigRequestCookies;
    use Dflydev\FigCookies\FigResponseCookies;
    use Dflydev\FigCookies\SetCookie;
    use Dflydev\FigCookies\SetCookies;
    use Slim\Exception\HttpNotFoundException;
    use Psr\Http\Message\ResponseInterface as Response;
    use Coco\downloader\Downloader;
    use Coco\downloader\resource\File;
    use Coco\sse\processor\Psr7Processor;
    use Coco\sse\SSE;
    use Slim\Psr7\NonBufferedBody;
    use Symfony\Component\Cache\CacheItem;
    use Zxing\QrReader;

    use Endroid\QrCode\Color\Color;
    use Endroid\QrCode\Encoding\Encoding;
    use Endroid\QrCode\ErrorCorrectionLevel;
    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Label\Label;
    use Endroid\QrCode\Logo\Logo;
    use Endroid\QrCode\RoundBlockSizeMode;
    use Endroid\QrCode\Writer\PngWriter;

    use OpenApi\Annotations as OA;
    use \wapmorgan\UnifiedArchive\UnifiedArchive;

    class Test extends BaseController
    {
        public function __construct(WebControllerWrapper $wrapper)
        {
            parent::__construct($wrapper);
        }

        public function index(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $response->getBody()->write("Hello index ");

            return $response;
        }

        public function unzip(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $output_dir = 'data/unzip/files';
            $zip_file = 'data/zip.zip';

            is_dir($output_dir) or mkdir($output_dir, 777, true);

            // archive.rar, archive.tar.bz2
            $archive = UnifiedArchive::open($zip_file);

            if (disk_free_space($output_dir) < $archive->getOriginalSize())
            {
                throw new \RuntimeException('No needed space available. Need ' . ($archive->getOriginalSize() - disk_free_space($output_dir)) . ' byte(s) more');
            }

            $extracted = $archive->extract($output_dir);

            return $response;
        }

        public function zip(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $output_dir = 'data';
            $zip_file = 'data/zip1.zip';

            UnifiedArchive::create([
                'zips' => $output_dir,
            ], $zip_file);

            return $response;
        }

        public function cache(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $data = $this->cocoApp->cache->get('cocoAppCacheTest', function(CacheItem $item) {
                echo 'by callable';
                echo PHP_EOL;

                return '-----------cocoApp data test----------';
            });

            $this->cocoApp->cache->delete('cocoAppCacheTest');

            $response->getBody()->write($data);

            return $response;
        }

        public function qrcodeRead(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $qrcode = new QrReader('data/qrcode.png');
            $text   = $qrcode->text();

            $response->getBody()->write($text);

            return $response;
        }

        public function qrcodeWrite(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $writer = new PngWriter();

            // Create QR code
            $qrCode = QrCode::create('[abc]')->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
                ->setSize(300)->setMargin(10)
                ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));

            // Create generic logo
            $logo = Logo::create('data/dog.png')->setResizeToWidth(50)->setPunchoutBackground(true);

            // Create generic label
            $label = Label::create('Label')->setTextColor(new Color(255, 0, 0));

            $result = $writer->write($qrCode, $logo, $label);

//            header('Content-Type: '.$result->getMimeType());
//            echo $result->getString();

//            $dataUri = $result->getDataUri();

            $result->saveToFile('data/qrcode.png');

            return $response;
        }

        public function sessions(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            /*----------------------------------------------------------------------------*/
            $storage = new \Coco\session\storages\Redis();
            SessionManager::InitStorage($storage);
            SessionManager::setExpire(200);
            SessionManager::setBase64Factor('_-.ACDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 'B');

            //获取cookie 中的
            $token_ = FigRequestCookies::get($request, 'token')->getValue();

            //get参数
            if (!$token_)
            {
                $get_   = $request->getQueryParams();
                $token_ = $get_['token'] ?? null;
            }

            //获取post参数
            if (!$token_)
            {
                $data   = $request->getParsedBody();
                $token_ = $data['token'] ?? null;
            }

            //获取 header中的
            if (!$token_)
            {
                $token_ = $request->getHeaderLine('Authorization') ?? null;
            }

            //都没有就给个新的
            if (!$token_)
            {
                $token_ = SessionManager::generateToken();
            }

            $container = SessionManager::getSessionContainer('forentend', $token_);

            /*----------------------------------------------------------------------------*/

            //获取请求cookie
            $cookie = FigRequestCookies::get($request, 'theme', 'default-theme');
            echo $cookie->getValue();
            echo PHP_EOL;

            //设置请求cookie
            $request = FigRequestCookies::set($request, Cookie::create('theme', 'blue'));

            //移除请求cookie
            $request = FigRequestCookies::remove($request, 'theme');

            //修改请求cookie
            $modify  = function(Cookie $cookie) {
                $value = $cookie->getValue();

                return $cookie->withValue($value);
            };
            $request = FigRequestCookies::modify($request, 'theme', $modify);

            /*-------------------------------*/

            $setCookie = FigResponseCookies::get($response, 'theme');
            echo $setCookie->getValue();
            echo PHP_EOL;

            //设置响应cookie
            $response = FigResponseCookies::set($response, SetCookie::create('theme')->withValue('33333333')
//                ->withDomain('example.com')
//                ->withPath('/firewall')
            );

            //移除响应cookie
            $response = FigResponseCookies::remove($response, 'theme');

            //修改响应cookie
            $modify   = function(SetCookie $setCookie) {
                $value = $setCookie->getValue();

                return $setCookie
//                    ->withValue($newValue)
//                    ->withExpires($newExpires)
                    ;
            };
            $response = FigResponseCookies::modify($response, 'theme', $modify);

            //设置cookie过期
            $setCookie = SetCookie::create('ba')->withValue('UQdfdafpJJ23k111m')->withPath('/')
                ->withDomain('.example.com');

            FigResponseCookies::set($response, $setCookie->expire());

            /*----------------------------------------------------------------------------*/
            $response->getBody()->write("Hello sessions " . PHP_EOL);

            return $response;
        }

        public function params(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $this->respondJson([
                [
                    "name" => $this->resolveArg('name'),
                ],
                $request->getQueryParams(),
            ]);

            return $response;
        }

        public function twig(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

//            https://packagist.org/packages/slim/twig-view
//            https://twig.symfony.com/doc/3.x/

            $data = [
                'staticPath' => $this->staticPath,
                'api_url'    => $slim->getRouteCollector()->getRouteParser()->urlFor('coco_api_'),
            ];

            $this->view('twig.twig', $data);

            return $response;
        }
        public function download(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $file = './data/1.jpg';

            $source = new File($file);
//    $source = new Strings('123456789');

            $nonBufferedBody = new \Slim\Psr7\NonBufferedBody();
            $response        = $response->withBody($nonBufferedBody);
            $processor       = new \Coco\downloader\processor\Psr7Processor($response);

            $d = new Downloader($source, $processor);

            $d->setDownloadName('1.jpg');

            $d->dispositionInline();
//        $d->dispositionAttachment();

//            $d->setLimitRateKB(1024 * 1024 * 10);
//    $d->setBufferSize(1024);

            $d->setOn404Callback(function(\Coco\downloader\processor\Psr7Processor $processor) use ($response) {
                $processor->getResponse()->getBody()->write('File not found');
            });

            $d->setOn416Callback(function(\Coco\downloader\processor\Psr7Processor $processor) {
                $processor->getResponse()->getBody()->write('范围错误');
            });

            $d->send();

            $response = $processor->getResponse();

            return $response;
        }

        public function event(): Response
        {
            $request      = $this->request;
            $response     = $this->response;
            $args         = $this->args;
            $routeContext = $this->routeContext;
            $route        = $this->route;
            $cocoApp      = $this->cocoApp;
            $slim         = $this->slimApp;

            // return NotFound for non-existent route
            if (empty($route))
            {
                throw new HttpNotFoundException($request);
            }

            $name      = $route->getName();
            $groups    = $route->getGroups();
            $methods   = $route->getMethods();
            $arguments = $route->getArguments();

            $response = $response->withBody(new NonBufferedBody());

            $processor = new Psr7Processor($response);

            SSE::init($processor);

            $id = 0;
            while (1)
            {
                $now = date('Y-m-d H:i:s');

                SSE::getEventIns('update')->send(json_encode([
                    "id"   => $id,
                    "data" => $now,
                ]));

                $id++;

                sleep(1);

                if ($id > 100)
                {
                    break;
                }
            }

            return $processor->getResponse();
        }
    }
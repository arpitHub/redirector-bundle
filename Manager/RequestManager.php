<?php
namespace Skonsoft\Bundle\RedirectorBundle\Manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Yaml\Parser as YamlParser;

/**
 * Description of RequestManager
 *
 * @author skander
 */
class RequestManager
{
    /**
     *
     * @var array list of redirected urls
     */
    protected $redirectedUrls = array();

    /**
     *
     * @var string file where are saved url to redirect
     */
    protected $sourceFile;

    /**
     * 
     * @param string $sourceFile where redirected urls are stored
     */
    public function __construct($sourceFile)
    {
        $this->sourceFile = $sourceFile;

        $this->loadUrls($sourceFile);
    }

    protected function loadUrls($sourceFile)
    {
        $parser = new YamlParser();
        $this->redirectedUrls = $parser->parse(file_get_contents($sourceFile));
    }

    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|null RedirectResponse if URL is redirectable, else, null
     * @throws \Exception if params are not set correctly
     */
    public function getRedirectedResponse(Request $request)
    {
        if (empty($this->redirectedUrls) || count($this->redirectedUrls) <= 0) {
            return null;
        }

        $error = "'%s' key should be set in redirected url '%s' in your config file " . $this->sourceFile;
        $requestUri = $request->getPathInfo();

        foreach ($this->redirectedUrls as $key => $urlConf) {
            if (!isset($urlConf['from'])) {
                throw new \Exception(sprintf($error, 'from', $key));
            }
            if (!isset($urlConf['to'])) {
                throw new \Exception(sprintf($error, 'from', $key));
            }

            if ($requestUri === $urlConf['from']) {
                $redirectTo = '%s' . $urlConf['to'];
                $host = isset($urlConf['host']) ? $urlConf['host'] : '';
                $code = isset($urlConf['http_code']) ? $urlConf['http_code'] : 302;
                return new RedirectResponse(sprintf($redirectTo, $host), $code);
            }
        }

        return null;
    }

}

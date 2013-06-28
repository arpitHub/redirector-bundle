<?php
namespace Skonsoft\Bundle\RedirectorBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Skonsoft\Bundle\RedirectorBundle\Manager\RequestManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Description of RequestListener
 *
 * @author skander
 */
class RequestListener
{
    /**
     *
     * @var \Skonsoft\Bundle\RedirectorBundle\Manager\RequestManager 
     */
    protected $requestManager;
    
    public function __construct(RequestManager $requestManager)
    {
        $this->setRequestManager($requestManager);
    }

    /**
     * bind Request, if url is redirectable, it will be redirected to new one
     * 
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $response = $this->getRequestManager()->getRedirectedResponse($event->getRequest());
        if($response instanceof RedirectResponse){
            $event->setResponse($response);
        }
    }

    /**
     * 
     * @return \Skonsoft\Bundle\RedirectorBundle\Manager\RequestManager
     */
    public function getRequestManager()
    {
        return $this->requestManager;
    }

    public function setRequestManager(\Skonsoft\Bundle\RedirectorBundle\Manager\RequestManager $requestManager)
    {
        $this->requestManager = $requestManager;
        return $this;
    }

}

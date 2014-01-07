<?php

/*
 * This file is part of the IRNewsBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;
use IR\Bundle\NewsBundle\IRNewsEvents;

/**
 * Flash Listener.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class FlashListener implements EventSubscriberInterface
{
    private static $successMessages = array(
        IRNewsEvents::ARTICLE_CREATE_COMPLETED => 'admin.article.flash.created',
        IRNewsEvents::ARTICLE_EDIT_COMPLETED => 'admin.article.flash.updated',
        IRNewsEvents::ARTICLE_DELETE_COMPLETED => 'admin.article.flash.deleted',        
    );

    /**
     * @var SessionInterface
     */    
    protected $session;
    
    /**
     * @var TranslatorInterface
     */    
    protected $translator;

    
   /**
    * Constructor.
    *
    * @param SessionInterface    $session
    * @param TranslatorInterface $translator
    */            
    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */        
    public static function getSubscribedEvents()
    {
        return array(
            IRNewsEvents::ARTICLE_CREATE_COMPLETED => 'addSuccessFlash',
            IRNewsEvents::ARTICLE_EDIT_COMPLETED => 'addSuccessFlash',
            IRNewsEvents::ARTICLE_DELETE_COMPLETED => 'addSuccessFlash',          
        );
    }

    /**
     * Adds a success flash message.
     * 
     * @param Event $event
     */            
    public function addSuccessFlash(Event $event)
    {
        if (!isset(static::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->session->getFlashBag()->add('success', $this->trans(static::$successMessages[$event->getName()]));
    }

    /**
     * Translates a message.
     * 
     * @param string $message
     * @param array  $params
     * 
     * @return string
     */       
    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'ir_news');
    }
}
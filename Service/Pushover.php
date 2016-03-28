<?php

namespace Eheuje\PushoverBundle\Service;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Stopwatch\StopwatchEvent;

class Pushover
{
    const ADDITIONNAL_INFORMATION = 'additional_information';
    const ADDITIONNAL_INFORMATION_DURATION = 'duration';
    const ADDITIONNAL_INFORMATION_MEMORY = 'memory';

    const OPTION_TOKEN = 'token';
    const OPTION_USER = 'user';
    const OPTION_MESSAGE = 'message';
    const OPTION_TITLE = 'title';
    const OPTION_DEVICE = 'device';

    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var StopwatchEvent
     */
    protected $stopwatchEvent;

    /**
     * @var array
     */
    protected $additionalInformation;

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function push()
    {
        $this->setOption(self::OPTION_MESSAGE, $this->getFullMessage());
        curl_setopt_array($ch = curl_init(), [
            CURLOPT_URL => "https://api.pushover.net/1/messages.json",
            CURLOPT_POSTFIELDS => $this->options,
            CURLOPT_SAFE_UPLOAD => true,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->options[self::OPTION_TOKEN] = $apiKey;
    }

    /**
     * @param string $userKey
     */
    public function setUserKey($userKey)
    {
        $this->options[self::OPTION_USER] = $userKey;
    }

    /**
     * @param StopwatchEvent $stopwatchEvent
     * @return $this
     */
    public function setStopwatchEvent($stopwatchEvent)
    {
        $this->stopwatchEvent = $stopwatchEvent;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getFullMessage()
    {
        $fullMessage[] = $this->message;
        if ($this->stopwatchEvent instanceof StopwatchEvent) {
            if ($this->additionalInformation[self::ADDITIONNAL_INFORMATION_DURATION]) {
                $fullMessage[] = ">>> Duration : {$this->stopwatchEvent->getDuration()} milliseconds";
            }
            if ($this->additionalInformation[self::ADDITIONNAL_INFORMATION_MEMORY]) {
                $fullMessage[] = ">>> Memory : {$this->stopwatchEvent->getMemory()} bytes";
            }
        }
        return implode("\n", $fullMessage);
    }

    /**
     * @param array $additionalInformation
     */
    public function setAdditionalInformation($additionalInformation)
    {
        $this->additionalInformation = $additionalInformation;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }
}
<?php

namespace Azeroglu\Telegram;

use GuzzleHttp\Client;

class Telegram
{
    protected $client;
    protected $chatId;
    protected $token;
    protected $params = [];

    public function __construct()
    {
        $this->client = new Client();
        $this->token  = env('TELEGRAM_BOT_TOKEN');
    }

    /*
     * Get Url
     * */
    protected function getUrl($method): string
    {
        return 'https://api.telegram.org/bot' . $this->token . '/' . $method;
    }

    /*
     * Get Data
     * */
    public function getData()
    {
        $data  = json_decode(file_get_contents('php://input'), true);
        $query = @$data['callback_query'];
        if ($data):
            if (@$query):
                if (isset($query['from']['id'])):
                    $this->chatId = $query['from']['id'];
                endif;
            else:
                if (isset($data['message']['chat']['id'])):
                    $this->chatId = $data['message']['chat']['id'];
                endif;
            endif;
            return $data;
        endif;
        return null;
    }

    /*
     * Set Webhook
     * */
    public function setWebhook($url)
    {
        return $this->request('setWebhook', ['url' => $url]);
    }

    /*
     * Request
     * */
    protected function request($method, $post = [])
    {
        if (!$this->token) return 'Token null';
        try {
            if ($this->chatId) $post = array_merge($post, ['chat_id' => $this->chatId]);
            return $this->client->post($this->getUrl($method), ['form_params' => $post])->getBody();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /*
     * Token
     * */
    public function token($token = null)
    {
        $this->token = $token;
        return $this;
    }

    /*
     * Chat Id
     * */
    public function chatId($chatId)
    {
        $this->params = array_merge($this->params, ['chat_id' => $chatId]);
        return $this;
    }

    /*
     * Content
     * */
    public function content($text)
    {
        $this->params = array_merge($this->params, ['text' => mb_substr($text, 0, 4000, 'UTF-8')]);
        return $this;
    }

    /*
     * Parse Mode
     * */
    public function parseMode($mode)
    {
        $this->params = array_merge($this->params, ['parse_mode' => $mode]);
        return $this;
    }

    /*
     * Inline Buttons
     * */
    public function inlineButtons($buttons)
    {
        $buttonArr = [[$buttons]];
        if (@is_array($buttons[0])):
            $buttonArr = [$buttons];
        endif;
        $this->replyMarkup([
            'inline_keyboard' => $buttonArr
        ]);
        return $this;
    }

    /*
     * Photo
     * */
    public function photo($url)
    {
        $this->params = array_merge($this->params, ['photo' => $url]);
        return $this;
    }

    /*
     * Caption
     * */
    public function caption($text)
    {
        $this->params = array_merge($this->params, ['caption' => mb_substr($text, 0, 1000, 'UTF-8')]);
        return $this;
    }

    /*
     * Document
     * */
    public function document($url)
    {
        $this->params = array_merge($this->params, ['document' => $url]);
        return $this;
    }

    /*
     * Thumbnail
     * */
    public function thumbnail($url)
    {
        $this->params = array_merge($this->params, ['thumb' => $url]);
        return $this;
    }

    /*
     * Video
     * */
    public function video($url)
    {
        $this->params = array_merge($this->params, ['video' => $url]);
        return $this;
    }

    /*
     * Duration
     * */
    public function duration($duration)
    {
        $this->params = array_merge($this->params, ['duration' => $duration]);
        return $this;
    }

    /*
     * Width
     * */
    public function width($width)
    {
        $this->params = array_merge($this->params, ['width' => $width]);
        return $this;
    }

    /*
     * Height
     * */
    public function height($height)
    {
        $this->params = array_merge($this->params, ['height' => $height]);
        return $this;
    }

    /*
     * Page Preview
     * */
    public function pagePreview($val)
    {
        $this->params = array_merge($this->params, ['disable_web_page_preview' => $val]);
        return $this;
    }

    /*
     * Reply Markup
     * */
    public function replyMarkup($markup)
    {
        $this->params = array_merge($this->params, ['reply_markup' => json_encode($markup)]);
        return $this;
    }

    /*
     * Send Message
     * */
    public function sendMessage()
    {
        return $this->request('sendMessage', $this->params);
    }

    /*
     * Send Photo
     * */
    public function sendPhoto()
    {
        return $this->request('sendPhoto', $this->params);
    }

    /*
     * Send Document
     * */
    public function sendDocument()
    {
        return $this->request('sendDocument', $this->params);
    }

    /*
     * Send Video
     * */
    public function sendVideo()
    {
        return $this->request('sendVideo', $this->params);
    }
}

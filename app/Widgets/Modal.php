<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Modal extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    protected $title = "";
    protected $form = "";
    protected $data = "";
    protected $type = "";

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    function __construct(array $config = []){
        $this->title = $config['title'];
        $this->form = $config['form'];
        $this->data = $config['data'];
        $this->type = $config['type'];
    }
    public function run()
    {
        return view('widgets.modal', [
            'title' => $this->title,
            'form' => view($this->form, $this->data),
            'type' => $this->type
        ]);
    }
}

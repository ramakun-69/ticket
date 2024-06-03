<?php

namespace App\Widgets;

use App\Models\MPegawai;
use App\Models\MShift;
use Arrilot\Widgets\AbstractWidget;

class ChangeShift extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    protected $title = "";
    protected $form = "";

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    function __construct(array $config = [])
    {
        $this->title = $config['title'];
        $this->form = $config['form'];    
    }
    public function run()
    {
       
        return view('widgets.change_shift', [
            'config' => $this->config,
            'title' => $this->title,
            'form' => view($this->form),
        ]);
    }
}

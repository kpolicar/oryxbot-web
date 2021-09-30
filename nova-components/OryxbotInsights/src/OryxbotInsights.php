<?php

namespace Kpolicar\OryxbotInsights;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class OryxbotInsights extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('oryxbot-insights', __DIR__.'/../dist/js/tool.js');
        Nova::style('oryxbot-insights', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('oryxbot-insights::navigation');
    }
}

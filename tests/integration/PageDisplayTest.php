<?php

class PageDisplayTest extends TestCase
{
    public function test_page_is_displayed()
    {
        $this->visit('api-tester')->see('<vm-api-tester-main>');
    }

    public function test_page_is_not_displayed_when_disabled()
    {
        Config::set('api-tester.enabled', false);

        $this->get('api-tester')->seeStatusCode(403);
    }

    public function test_assets_are_retrievable()
    {
        $this->get('api-tester/assets/api-tester.js')->seeStatusCode(200);
        $this->get('api-tester/assets/api-tester.css')->seeStatusCode(200);
    }
}

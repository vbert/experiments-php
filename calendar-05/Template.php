<?php
/*
 * Project: calendar-05
 * File: /Template.php
 * File Created: 2024-06-15, 21:19:53
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-06-15, 21:20:11
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

class Template {
    private $templateDir;

    public function __construct($templateDir) {
        $this->templateDir = $templateDir;
    }

    public function render($template, $data = []) {
        $templatePath = $this->templateDir . '/' . $template . '.html';

        if (!file_exists($templatePath)) {
            throw new Exception("Template file not found: " . $templatePath);
        }

        extract($data);
        ob_start();
        include($templatePath);
        return ob_get_clean();
    }
}

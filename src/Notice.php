<?php

namespace WPAdminHelpers;

class Notice
{
  /**
   * Create a new admin notice
   * @param  string $message Message to display
   * @param  string $type    Type of message. success (default), warning, error
   * @return null
   */
  public function __construct($message, $type = "success")
  {
    // allow for dependency injection (testing)
    $args = func_get_args();
    $args = array_shift($args);

    $class = $type == "success" ? "updated" : "error";

    add_action("admin_notices", function () use ($message, $class) {
      echo '<div class="' . $class . '"><p>' . $message . '</p></div>';
    });
  }
}

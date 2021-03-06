<?php

namespace WPAdminHelpers\Settings;

class SubMenuPage
{
	protected $parentSlug;
	protected $pageTitle;
	protected $menuTitle;
	protected $capability;
	protected $content;

	/**
	 * Create a submenu page in the WordPress admin
	 * @param string $parentSlug The slug name for the parent menu (or the file name of a standard
	 *                           WordPress admin page). Use NULL or set to 'options.php' if you want
	 *                           to create a page that doesn't appear in any menu
	 * @param string $pageTitle  The text to be displayed in the title tags of the page when the menu is selected
	 * @param string $menuTitle  The text to be used for the menu
	 * @param string $capability The capability required for this menu to be displayed to the user.
	 * @param string $menuSlug   The slug name to refer to this menu by (should be unique for this menu).
	 *                           If you want to NOT duplicate the parent menu item, you need to set the name
	 *                           of the $menu_slug exactly the same as the parent slug.
	 * @param string $content    Content to add to the top of the page. Example: description of what the page does
	 */
	public function __construct($parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $content = "")
	{
		$this->parentSlug = $parentSlug;
		$this->pageTitle = $pageTitle;
		$this->menuTitle = $menuTitle;
		$this->capability = $capability;
		$this->menuSlug = $menuSlug;
		$this->content = $content;

		$this->addSubmenuPage();
	}

	public function __get($prop)
  {
    if ($prop == "id") {
      return $this->menuSlug;
    }
  }

  protected function addSubmenuPage()
  {
  	add_action("admin_menu", function () {

			add_submenu_page(
				$this->parentSlug,
				$this->pageTitle,
				$this->menuTitle,
				$this->capability,
				$this->menuSlug,
				array($this, "addContent")
			);

		});
  }

	public function addContent() {
	?>
	    <div class="wrap">

	        <?php screen_icon(); ?>
	        <h2><?php echo $this->pageTitle; ?></h2>
	        <?php echo $this->content; ?>

	        <form method="post" action="options.php">

	            <?php settings_fields($this->menuSlug); ?>
	            <?php do_settings_sections($this->menuSlug); ?>
	            <?php submit_button(); ?>

	        </form>

	    </div>
	<?php
	}
}

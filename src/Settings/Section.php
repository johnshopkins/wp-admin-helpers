<?php

namespace WPAdminHelpers\Settings;

class Section
{
	public $id;
	protected $menuPage;
	protected $sectionSlug;
	protected $title;
	protected $content;

  /**
   * Creates a setting section in the WordPress admin.
   * Settings Sections are the groups of settings you see
   * on WordPress settings pages with a shared heading.
   *
   * @param object $menuPage    Menu page to attach this settings section to.
   *                            Instance of SubMenuPage or a string.
   * @param string $sectionSlug Section slug
   * @param string $title       Section title
   * @param array  $fields      Array describing the fields in this section
   * @param string $content     Content to add to the top of the section.
   */
	public function __construct($menuPage, $sectionSlug, $title, $fields, $content = "")
	{
		$this->menuPage = is_string($menuPage) ? $menuPage : $menuPage->id;
		$this->sectionSlug = $sectionSlug;
		$this->title = $title;
		$this->fields = $fields;
		$this->content = $content;

    // create a unique identifier for this section.
    // WordPress calls this a "string for use in the 'id' attribute of tags"
		$this->id = "{$this->menuPage}_{$this->sectionSlug}";

    $this->addSection();
		$this->createFields();
	}

  public function addContent()
  {
    echo $this->content;
  }

  protected function addSection()
  {
    add_action("admin_init", function () {

      add_settings_section(
        $this->id,
        $this->title,
        array($this, "addContent"),
        $this->menuPage
      );

    });
  }

	protected function createFields()
  {
    foreach ($this->fields as $fieldName => $details) {

      $validation = isset($details["validation"]) ? $details["validation"] : null;
      $default = isset($details["default"]) ? $details["default"] : null;
      new Field(
        $fieldName,
        $details,
        $this->menuPage,
        $this->id,
        $validation
      );

    }
  }
}

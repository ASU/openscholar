Feature:
  Testing the galleries tab.

  @api @wip
  Scenario: Test the Galleries tab
    Given I visit "john"
     When I click "Galleries"
      And I click "Kittens gallery"
     Then I should see the images:
      | slideshow1 |
      | slideshow2 |
      | slideshow3 |

  @api @debug @wip
  Scenario: Test the Galleries tab
    Given I visit "/user"
     Then I should print page


  @api @wip
  Scenario: Verfity that "galleries" tab shows all nodes.
    Given I visit "john/galleries/science/wind"
     Then I should see "Kittens gallery"
      And I should see "JFK"

  @api @wip
  Scenario: Verfity that "galleries" tab shows can filter nodes by term.
     Given I visit "john/galleries/science/fire"
      Then I should see "Kittens gallery"
       And I should not see "jfk"

  @api @features_first
  Scenario: Create new image gallery content
     Given I am logging in as "john"
        And I visit "john/node/add/media-gallery"
       When I fill in "Title" with "Safari"
       When I fill in "Description" with "Visit to world safari"
        And I press "Save"
        And I sleep for "2"
       Then I should see "Safari"
       And I should see "Visit to world safari"

  @api @features_first
  Scenario: Edit existing image gallery content
     Given I am logging in as "john"
        And I visit the unaliased edit path of "galleries/safari" on vsite "john"
       When I fill in "Title" with "World Safari"
       When I fill in "Description" with "Enjoying world safari"
        And I press "Save"
        And I sleep for "2"
       Then I should see "World Safari"
       And I should see "Enjoying world safari"

  @api @features_first @javascript
  Scenario: Add media to existing gallery
     Given I am logging in as "john"
       And I visit "john/galleries/safari"
       And I sleep for "2"
      When I click "Add media"
       And I wait "1 second" for the media browser to open
       And I should wait for the text "Please wait while we get information on your files." to "disappear"
       And I drop the file "safari.jpg" onto the "Drag and drop files here." area
       And I should wait for "File Edit" directive to "appear"
       And I fill in the field "Alt Text" with the node "safari"
       And I click on the "Save" control
       And I visit "john/galleries/safari"
     Then I should see the images:
      | safari |

  @api @features_first @javascript
  Scenario: Edit media of a existing gallery
     Given I am logging in as "john"
       And I visit "john/galleries/safari"
       And I click the gear icon in the node content region
       And I click "Edit" in the gear menu in node content
       And I click on the "Advanced (change filename, replace file, add a caption, etc.)" control
       And I fill in "File Name" with "safari_one.jpg"
       And I click on the "Save" control
       And I wait for page actions to complete
       And I visit "john/galleries/safari"
      Then I should see the images:
      | safari_one |

  @api @features_first @javascript
  Scenario: Delete media of a existing gallery
     Given I am logging in as "john"
       And I visit "john/galleries/safari"
       And I click the gear icon in the node content region
       And I click "Remove" in the gear menu in node content
       And the overlay opens
       And I press "Remove file"
       And I wait for page actions to complete
       And the overlay closes
       And I should see "removed from the gallery"

  @api @features_second @javascript
   Scenario: Add slideshow image content permission
     Given I am logging in as "john"
       And I create a "Slideshow" widget for the vsite "john" with the following <settings>:
           | edit-description  | Slideshow | textfield   |
           | edit-title        | Slideshow | textfield   |
     When the widget "Slideshow" is placed in the "About" layout
      And I visit "john/about"
     Then I should see "Add Slide"
      And I click "Add Slide"
      And the overlay opens
      And I press "edit-field-image-und-0-selected-file"
      And I wait "1 second" for the media browser to open
      And I should wait for the text "Please wait while we get information on your files." to "disappear"
      And I drop the file "desert.jpg" onto the "Drag and drop files here." area
      And I should wait for "File Edit" directive to "appear"
      And I fill in "fe-alt-text" with "Desert"
      And I click on the "Save" control
      And I wait for page actions to complete
      And I press "Save"
      And the overlay closes
      And I should see "Slideshow Image desert.jpg has been created"

  @api @features_second @javascript
   Scenario: Edit own slideshow image content permission
     Given I am logging in as "john"
       And I visit "john/cp/content"
       And I click "desert.jpg"
       And I click the gear icon in the content region
       And I click "Edit" in the gear menu
       And the overlay opens
       And I fill in "Description" with "Desert Image"
       And I press "Save"
       And I wait for page actions to complete
       And the overlay closes
       And I should see "Desert Image"

  @api @features_second
   Scenario: Edit any slideshow image content permission
     Given I am logging in as "alexander"
      When I go to "john/cp/content"
      Then I should get a "403" HTTP response

  @api @features_second
   Scenario: Delete any slideshow image content permission
     Given I am logging in as "alexander"
      When I go to "john/cp/content"
      Then I should get a "403" HTTP response

  @api @features_second
   Scenario: Delete own slideshow image content permission
     Given I am logging in as "john"
       And I visit "john/cp/content"
       And I click "desert.jpg"
       And I click the gear icon in the content region
       And I click "Delete" in the gear menu
       And the overlay opens
       And I press "Delete"
       And I wait for page actions to complete
       And the overlay closes
       And I should see "has been deleted"

  @api @features_first @javascript
  Scenario: Delete existing image gallery content
     Given I am logging in as "john"
        And I visit the unaliased edit path of "galleries/safari" on vsite "john"
       And I sleep for "2"
      When I click "Delete this media gallery"
      Then I should see "This action cannot be undone."
       And I press "Delete"
       Then I should see "has been deleted"

  @api @feature_second
  Scenario: Permission to add gallery Content
    Given I am logging in as "john"
      And I visit "john/cp/users/add"
      And I fill in "Member" with "alexander"
      And I press "Add member"
      And I sleep for "5"
     Then I should see "alexander has been added to the group John."
      And I visit "john/cp/users/add"
      And I fill in "Member" with "michelle"
      And I press "Add member"
      And I sleep for "5"
     Then I should see "michelle has been added to the group John."
      And I visit "user/logout"
    Given I am logging in as "michelle"
      And I visit "john/node/add/media-gallery"
     When I fill in "Title" with "Marilyn Monroe"
      And I press "Save"
      And I sleep for "2"
     Then I should see "Marilyn Monroe"

  @api @feature_second
  Scenario: Permission to edit own content
    Given I am logging in as "michelle"
      And I visit the unaliased edit path of "galleries/marilyn-monroe" on vsite "john"
      And I fill in "Title" with "Marilyn Monroe Gallery"
      And I press "Save"
     Then I should see "Marilyn Monroe Gallery"

  @api @feature_second
  Scenario: Permission to edit any content
    Given I am logging in as "alexander"
      And I visit the unaliased edit path of "galleries/marilyn-monroe" on vsite "john"
     Then I should see "Access Denied"

  @api @feature_second
  Scenario: Permission to delete any content
    Given I am logging in as "alexander"
      And I visit the unaliased delete path of "galleries/marilyn-monroe" on vsite "john"
     Then I should see "Access Denied"

  @api @feature_second
  Scenario: Permission to delete own content
    Given I am logging in as "michelle"
      And I visit the unaliased edit path of "galleries/marilyn-monroe" on vsite "john"
      And I click "Delete this media gallery"
     Then I should see "This action cannot be undone."
      And I press "Delete"
     Then I should see "has been deleted"
Feature:
  Testing booklets

 @api @features_first @create_new_booklets_content @os_booklets
 Scenario: Create new booklets content
    Given I am logging in as "john"
      And I visit "john/node/add/book"
     When I fill in "Title" with "Profiles In Courage"
     When I fill in "Body" with "Profiles in Courage is a 1957 Pulitzer Prize-winning volume of short biographies describing acts of bravery and integrity by eight United States Senators."
      And I press "Save"
      And I sleep for "5"
     Then I should see "Profiles In Courage"
      And I should see "Pulitzer Prize-winning volume of short biographies"

 @api @features_first @edit_existing_booklets_content @os_booklets
 Scenario: Edit existing booklets content
    Given I am logging in as "john"
      And I visit the unaliased edit path of "book/profiles-courage" on vsite "john"
      And I fill in "Title" with "Profiles In Courage by John F. Kennedy and Ted Sorensen"
      And I fill in "Body" with " Profiles In Courage profiles senators who defied the opinions of their party and constituents to do what they felt was right and suffered severe criticism and losses in popularity because of their actions."
      And I press "Save"
      And I sleep for "5"
     Then I should see "profiles senators who defied the opinions"
      And I should see "by John F. Kennedy and Ted Sorensen"

 @api @features_first @os_booklets @add_child_page_to_existing_booklet_content
 Scenario: Add child page to existing booklet content
    Given I am logging in as "john"
      And I visit the site "john/book/profiles-courage"
      And I click "Add child page"
      And I fill in "Title" with "John Quincy Adams"
      And I fill in "Body" with "John Quincy Adams, from Massachusetts, for breaking away from the Federalist Party."
      And I press "Save"
      And I sleep for "5"
     Then I should see "John Quincy Adams"
      And I should see "from Massachusetts, for breaking"

 @api @features_first @os_booklets @add_a_second_child_page_to_existing_booklet_content
 Scenario: Add a second child page to existing booklet content
    Given I am logging in as "john"
      And I visit the site "john/book/profiles-courage"
      And I click "Add child page"
      And I fill in "Title" with "Daniel Webster"
      And I fill in "Body" with "Daniel Webster, also from Massachusetts, for speaking in favor of the Compromise of 1850."
      And I press "Save"
      And I sleep for "5"
     Then I should see "Daniel Webster"
      And I should see "for speaking in favor of the Compromise of 1850"
 @api @features_first @os_booklets @add_a_fourth_child_page_to_existing_booklet_content @eam_1245
 Scenario: Add a second child page to existing booklet content
    Given I am logging in as "john"
      And I visit the site "john/book/profiles-courage"
      And I click "Add child page"
      And I fill in "Title" with "Daniel Webster"
      And I fill in "Body" with "Daniel Webster, also from Massachusetts, for speaking in favor of the Compromise of 1850."
      And I press "Save"
      And I sleep for "5"
     Then I should see "Daniel Webster"
      And I should see "for speaking in favor of the Compromise of 1850"

 @api @features_first @os_booklets @add_more_child_pages_to_existing_booklet_content
 Scenario: Add a second child page to existing booklet content
    Given I am logging in as "john"
      And I visit the site "john/book/profiles-courage"
      And I click "Add child page"
      And I visit the "overlay" parameter in the current query string with "" appended on vsite ""
      And I sleep for "6"
      And I fill in "Title" with "Thomas Hart Benton"
#     And I fill in "Body" with "Thomas Hart Benton, from Missouri, for staying in the Democratic Party despite his opposition to the extension of slavery in the territories."
      And I press "Save"
      And I visit the site "john/book/profiles-courage"
      And I click "Add child page"
      And I visit the "overlay" parameter in the current query string with "" appended on vsite ""
      And I sleep for "6"
      And I fill in "Title" with "Sam Houston"
#     And I fill in "Body" with "Sam Houston, from Texas, for speaking against the Kansas–Nebraska Act of 1854, which would have allowed those two states to decide on the slavery question. Houston wanted to uphold the Missouri Compromise. His and Benton's votes against Kansas–Nebraska did just that. This was his most unpopular vote and he was defeated when running for re-election. Two years later he'd regained enough popularity to be elected Governor of Texas. However, when the state convened in special session and joined the Confederacy, Sam Houston refused to be inaugurated as governor, holding true to his ideal of preserving the Union."
      And I press "Save"

 @api @wip @os_booklets @change_order_of_booklet_content_in_outline
 Scenario: change order of booklet content in outline
    Given I am logging in as "john"
      And I visit the site "john/book/profiles-courage"
      And I click "John Quincy Adams"
      And I click the gear icon in the content region
      And I click "Edit" in the gear menu
      And I visit the "destination" parameter in the current query string with "edit" appended on vsite "john"
      And I click "Booklet information"
      And I select "-- Sam Houston" from "Parent item"
      And I press "Save"
     Then I should match the regex "TABLE\s+OF\s+CONTENTS\s+Profiles\s+In\s+Courage\s+Sam\s+Houston\s+John\s+Quincy\s+Adams\s+Thomas\s+Hart\s+Benton"


#@api @features_first @delete_any_booklets_content @os_booklets
#Scenario: Delete booklets content
#   Given I am logging in as "john"
#     And I visit the unaliased edit path of "book/profiles-courage" on vsite "john"
#    When I click "Delete this book page"
#    Then I should see "Are you sure you want to delete"
#    When I sleep for "5"
#     And I press "Delete"
#    Then I should see "has been deleted"

 @api @features_first @os_booklets @delete_booklet_content_in_outline
 Scenario: delete booklet content in outline
    Given I am logging in as "john"
      And I visit the site "john/book/profiles-courage"
      And I click the gear icon in the content region
      And I click "Outline" in the gear menu
      And I visit the "destination" parameter in the current query string with "outline" appended on vsite "john"
      And I click "delete"
     Then I should see "Are you sure you want to delete Daniel Webster?"
      And I press "Delete"
     Then I should see "Book page Daniel Webster has been deleted"
      And I click "Profiles In Courage"
     Then I should match the regex "TABLE\s+OF\s+CONTENTS\s+Profiles\s+In\s+Courage\s+John\s+Quincy\s+Adams"


#@api @features_first @os_booklets @change_order_of_booklet_content_using_booklet_information_field
#Scenario: change order of booklet content using "Booklet information" field
#   Given I am logging in as "john"
#     And I visit the site "john/book/profiles-courage"

#@api @features_first @os_booklets @correct_re_arrangement_of_booklet_outline_when_parent_is_deleted
#Scenario: correct re-arrangement of booklet outline when parent is deleted
#   Given I am logging in as "john"
#     And I visit the site "john/book/profiles-courage"

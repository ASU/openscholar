Feature:
  In order to see a site biblio publications
  I need to be able to issue a query via URL
  And get XML results

  @api
  Scenario: Test a query with unknown VSite, where the answer should be "unknown".
    Given I visit "harvard_activity_reports"
    Then I should get:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <response xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespacesSchemaLocation="far_response.xsd">
      <person huid="" action_status="unknown"/>
      <errorMessage></errorMessage>
    </response>
    """

  @api
  Scenario: Test a query with invalid VSite, where the answer should be "error".
    Given I visit "harvard_activity_reports?site_url=error-site"
    Then I should get:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <response xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespacesSchemaLocation="far_response.xsd">
      <person huid="" action_status="error"/>
      <errorMessage></errorMessage>
    </response>
    """

  @api
  Scenario: Test a query withing a VSite for a year with publication, where the answer should be "ok".
    Given I visit "john/harvard_activity_reports?year=1943"
    Then I should get:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <response xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespacesSchemaLocation="far_response.xsd">
      <person huid="" action_status="ok">
        <publication id="9" pubType="Book" pubSource="OpenScholar">
          <citation>admin, and Smith, John K. The Little Prince. </citation>
          <linkToArticle></linkToArticle>
          <yearOfPublication>1943</yearOfPublication>
        </publication>
      </person>
    </response>
    """

  @api
  Scenario: Test a query withing a VSite for a year with no publication, where the answer should be "ok".
    Given I visit "john/harvard_activity_reports"
    Then I should get:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <response xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespacesSchemaLocation="far_response.xsd">
      <person huid="" action_status="ok"/>
    </response>
    """

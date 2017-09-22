(function ($) {

  /**
   * Display dialog to choose between overwriting or creating a new exported Google Calendar.
   */
  Drupal.behaviors.osPromptForOverwriteOrCreateGoogleCalendar = {
    attach: function () {

      function osEventsDialogButton(overwrite, label) {

        
        this.button = {
          text: label,
          click: function () {
            var $this = $(this);
            $.ajax({
              url: document.location.pathname + '?overwrite=' + overwrite,
              type: 'POST',
              success: function (resp) {
                $this.dialog("option", "title", "Google Calendar Export complete");
              },
              beforeSend: function (xhr, settings) {
                $this.dialog("option", "title", "Exporting ...");
                $this.dialog("option", {buttons: {}});
                $this.html('<div class="jquery-autopager-ajax-loader" style="text-align:center;">' + 
                    Drupal.settings.CToolsModal.throbber + 
                '</div>');
              },
              complete: function () {
                $this.html('');
                $this.dialog("option", "buttons", [{ text: "Close", click: function () { $(this).dialog("close"); } }]);
              },
              error: function (resp) {
                alert(JSON.stringify(resp));
              }
            });
          }
        };
      }

      var button1 = new osEventsDialogButton(1, "Create New Google Calendar");
      var button2 = new osEventsDialogButton(0, "Overwrite Existing Google Calendar");

      $("#export-to-google-calendar-dialog-confirm").once(function () {

        $("#export-to-google-calendar-dialog-confirm").dialog({
          resizable: false,
          height: "auto",
          width: 600,
          modal: true,
          title: "Export to Google Calender",
          dialogClass: 'os_events_export_dialog',
          buttons: [
            button1.button,
            button2.button,
            {
              text: "Cancel",
              click: function () {
                $(this).dialog("close");
              }
            }
          ]
        });
      });

    }
  };

})(jQuery);

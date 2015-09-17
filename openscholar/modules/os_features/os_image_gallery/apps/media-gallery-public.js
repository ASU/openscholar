(function() {

  var m = angular.module('media-gallery-public', ['mediaBrowser', 'FileEditorModal']);

  m.run(function () {
    var fileEditLinks = angular.element('.media-gallery-media-item-thumbnail.contextual-links-region .contextual-links  .link-count-file-edit a');

    for (var i = 0; i < fileEditLinks.length; i++) {
      var elem = fileEditLinks[i],
        urlBits = elem.href.match(/file\/([\d]*)\/edit/);

      angular.element(elem).attr({
        href: '#',
        'file-editor-modal': '',
        fid: urlBits[1]
      });
    }

    if (Drupal && Drupal.media_gallery) {
      jQuery('a.media-gallery-add.launcher').unbind('click', Drupal.media_gallery.open_browser);

      // Mostly copied from media_gallery.addimage.js
      // We just need to force the file size settings to be passed to the media browser
      Drupal.media_gallery.open_browser = function (event) {
        event.preventDefault();
        event.stopPropagation();

        // get node id for the link that was clicked and save to settings (id attribute for parent article is node-[id])
        Drupal.settings.mediaGalleryNodeNid = jQuery(this).closest("article.contextual-links-region").attr('id').substring(5);

        var pluginOptions = {
          'id': 'media_gallery',
          'multiselect' : true ,
          'types': Drupal.settings.mediaGalleryAllowedMediaTypes,
          max_filesize: Drupal.settings.mediaGalleryMaxFilesize,
          max_filesize_raw: Drupal.settings.mediaGalleryMaxFilesizeRaw
        };
        Drupal.media.popups.mediaBrowser(Drupal.media_gallery.add_media, pluginOptions);
      }

      jQuery('a.media-gallery-add.launcher.media-gallery-add-processed').bind('click', Drupal.media_gallery.open_browser);
    }
  });
})();
DESCRIPTION
--------------------------
Module to add Vsite backup/export UI to OpenScholar.


INSTALLATION
--------------------------

Install as usual, see http://drupal.org/node/70151 for further information.

Enable Vsite Backup, Vsite Export, Vsite Import and Vsite Export RESTFUL
modules, for the full Vsite Backup and Restore suite.

Ensure site has a private file system path configured through the UI at
admin/config/media/file-system


DEPENDENCIES
--------------------------

DRUPAL MODULES
 - ctools 
 - vsite
 - vsite_menu
 - vsite_backup_restful
 - views
 - file_entity

PERMISSIONS
--------------------------

  - admin/people/permissions#module-vsite_backup
    
Grant File Entity's "View own private files" permission to the Authenticated
User role.

Grant other permissions as desired for Vsite Backup modules.

Note: Some permissions are intended to only be provided to sitewide
administrator users, as they grant powerful and potentially destructive
permissions to a role. Specifically, those permissions for importing backups.

CONFIGURATION
--------------------------

See INSTALLATION, PERMISSIONS, and PAGES sections.
  
API
--------------------------

MODULES
--------------------------

Contained in this folder:
  - vsite_backup
  - vsite_export
  - vsite_import

Not included, but required for imports:
  - vsite_backup_restful


PAGES
--------------------------

Export backups (Vsite owners):
  - <vsite-name-here>/vsite-backup

Import backups (for sitewide administrator users):
  - admin/config/vsite-import/manage

BLOCKS
--------------------------

HOOKS
--------------------------



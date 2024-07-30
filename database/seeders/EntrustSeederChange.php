<?php

namespace Database\Seeders;

use App\Models\Permission;


//manage Document Archives
$manageDocumentArchives = Permission::create(['name' => 'manage_document_archives', 'display_name' => ['ar'    =>  ' إدارة إرشيف المستندات',   'en'    =>  '’Manage Document Templates'], 'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '10',]);
$manageDocumentArchives->parent_show = $manageDocumentArchives->id;
$manageDocumentArchives->save();
$showDocumentArchives    =  Permission::create(['name' => 'show_document_archives', 'display_name'       =>    ['ar'   =>  'إرشيف المستندات',   'en'    =>  ' Document Templates'],   'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$createDocumentArchives  =  Permission::create(['name' => 'create_document_archives', 'display_name'     =>    ['ar'   =>  'إضافة إرشيف مستند جديد',   'en'    =>  'Add Document Template'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$displayDocumentArchives =  Permission::create(['name' => 'display_document_archives', 'display_name'    =>    ['ar'   =>  ' عرض إرشيف مستند',   'en'    =>  'Display Document Template'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$updateDocumentArchives  =  Permission::create(['name' => 'update_document_archives', 'display_name'     =>    ['ar'   =>  'تعديل إرشيف مستند',   'en'    =>  'Edit Document Template'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$deleteDocumentArchives  =  Permission::create(['name' => 'delete_document_archives', 'display_name'     =>    ['ar'   =>  'حذف إرشيف مستند',   'en'    =>  'Delete Document Template'],    'route' => 'document_archives', 'module' => 'document_archives', 'as' => 'document_archives.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);

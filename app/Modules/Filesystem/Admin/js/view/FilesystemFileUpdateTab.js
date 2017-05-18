Ext.define('Filesystem.view.FilesystemFileUpdateTab', 
	{
    extend: 'Ext.tab.Panel',
	alias: 'widget.Filesystem.view.FilesystemFileUpdateTab',
	
		requires:
		[
		"Filesystem.view.FilesystemFileUpdateForm"
		],
	
	name: "Filesystem",
	padding: 5,
	
	activeTab: 0,
	bodyBorder: false,
	border: false,
	deferredRender: false,
	forceLayout: true,
	
		items:
		[
			{
			title: "Название",
			layout: "fit",
			itemId: "tab_1",
				items:
				[
					{
					xtype: "Filesystem.view.FilesystemFileUpdateForm"	
					}
				]
			}
		]
	}
);
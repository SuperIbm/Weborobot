Ext.define('PageTemplate.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.PageTemplate.view.Panel',
	
	title: "Шаблоны страниц",
	icon: Admin.getApplication().Section.get("PageTemplate")["iconSmall"],
	layout: 'fit',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "PageTemplate.view.PageTemplateGrid"
			}
		],
		initComponent: function()
		{
			this.tools = 
			[
				{
				type: "gear",
				itemId: "FilesystemTpl",
				tooltip: "Управлять файлами",
				hidden: Admin.getApplication().Access.is("Filesystem", "isRead") == true ? false : true
				}
			];
		
		this.callParent();	
		}
	}
);
Ext.define('Page.view.PageTreeComponent', 
	{
    extend: 'Admin.view.ux.TreePanel',
	alias: 'widget.Page.view.PageTreeComponent',
	
	store: 'PageTreeComponent',
	name: 'PageTreeComponent',
	
		selModel:
		{
		xtype: "treemodel", 
		mode: "SINGL"
		},
	selType: "rowmodel",
		root:
		{
		allowDrop: false,
		id: -1
		},
	}
);
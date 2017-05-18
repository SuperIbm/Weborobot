Ext.define('Admin.view.AppDesctop', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Admin.view.AppDesctop',
	
		requires:
		[
		"Admin.view.AppBreadCrumb",
		"Admin.view.AppContent"
		], 
	
	region: "center",
	border: true,
	layout: 'fit',
	
	collapsible: false,
	frame: true,
	scrollable: true,
	iconCls: "icon_application",
	
		initComponent: function()
		{
		var Content = new Admin.view.AppContent();
		Admin.getApplication().App._setContent(Content);
		this.items = [Content];
		
		var BreadCrumb = new Admin.view.AppBreadCrumb();
		Admin.getApplication().App._setBreadCrumb(BreadCrumb);	
		this.tbar = [BreadCrumb];	
			
		this.callParent();
		}
	}
);
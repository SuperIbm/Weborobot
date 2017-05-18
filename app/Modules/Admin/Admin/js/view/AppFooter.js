Ext.define('Admin.view.AppFooter', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Admin.view.AppFooter',
	
	region: "south",
	
	split: false,
	bodyPadding: 0,
	cls: "footer",
	padding: "5, 0, 0, 0",
	
		initComponent: function()
		{
		var Dt = new Date();
		var year = Dt.getFullYear();
	
		this.html = "<div class='text'>" + '© 2008–' + year + ', <a href="http://www.weborobot.ru/" target="_blanck" class="link">www.weborobot.ru</a>' + "</div>";
		this.callParent();	
		}
	}
);
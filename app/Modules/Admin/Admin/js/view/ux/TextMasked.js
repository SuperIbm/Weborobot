// Подгрузим саму библиотеку
Ext.Loader.loadScript
(
	{
	url: "engine/node_modules/jquery.maskedinput/src/jquery.maskedinput.js"
	}
);


Ext.define("Admin.view.ux.TextMasked",
	{
	extend: "Ext.form.field.Text",
	xtype: "textMasked",
	alias: 'widget.textMasked',
		
		onRender: function()
		{
		this.callParent();
		var mask = this.mask;
		var id = this.id;
		
		$("#" + id + " INPUT").mask(mask);
		}
	}
);
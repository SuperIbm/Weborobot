Ext.define('Infoblock.view.field.InfoblockLabelInfoblockText', 
	{
    extend: 'Ext.form.field.Text',
	xtype: "Infoblock.view.field.InfoblockLabelInfoblockText",
	
	labelSeparator: "",
	labelWidth: 160,
	width: 450,
	
	name: "labelInfoblock",
	reference: "labelInfoblock",
	
	msgTarget: 'side',
	
		validator: function(value)
		{				
			if(Weborobot.Util.isLength(value, 1, 255) == false)
			return this.msgError;
			else return true;
		}
	}
);
	
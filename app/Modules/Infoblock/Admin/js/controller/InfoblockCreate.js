Ext.define('Infoblock.controller.InfoblockCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "InfoblockCreate",
	
	views: ["InfoblockCreateWindow"],
	stores: ['Infoblock'],
	
		routes:
		{
			"infoblockCreateTab/:id":
			{
				action: function(id)
				{
				this.getTabCreate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabCreate: "Infoblock\\.view\\.InfoblockCreateWindow[name='Infoblock'] Infoblock\\.view\\.InfoblockCreateTab[name='Infoblock']"
		},
	
		control:
		{			
			"Infoblock\\.view\\.InfoblockCreateWindow[name='Infoblock'] Infoblock\\.view\\.InfoblockCreateTab[name='Infoblock']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "infoblockCreateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"Infoblock\\.view\\.InfoblockCreateWindow[name='Infoblock'] button[action=send]":
			{
				click: function(button)
				{
				var thisObj = this;

					if(button.up("window").down("form").isValid() == true)
					{
					button.up("window").mask(thisObj.maskLoad);
					
					var data = button.up("window").down("form").getValues();
					data["code"] = button.up("window").down("ckeditor").getValue();
					var Infoblock = Ext.create(this.getModel("Infoblock"), data);
					Infoblock.setId(null);
					
						Infoblock.save
						(
							{							
								success: function(model, operation)
								{
								button.up("window").unmask();
									
									Ext.Msg.show
									(
										{
										title: thisObj.okTitle,
										msg: thisObj.okMsg,
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
									
								button.up("window").down("form").reset();
								button.up("window").down("ckeditor").setValue("");
								thisObj.getStore("Infoblock").load();	
								},
								failure: function(model, operation)
								{
								var result = Ext.decode(operation.getResponse().responseText);
								button.up("window").unmask();
								
									if(action.result.errormsg)
									{
										Ext.Msg.show
										(
											{
											title: thisObj.error,
											msg: action.result.errormsg,
											icon: Ext.MessageBox.ERROR,
											buttons: Ext.MessageBox.OK
											}
										);
									}
									else
									{
										Ext.Msg.show
										(
											{
											title: thisObj.error,
											msg: thisObj.errorMsgServer,
											icon: Ext.MessageBox.ERROR,
											buttons: Ext.MessageBox.OK
											}
										);	
									}
								}
							}
						);
					}
					else
					{
						Ext.Msg.show
						(
							{
							title: thisObj.warningNoCorrectTitle,
							msg: thisObj.warningNoCorrectMessage,
							icon: Ext.MessageBox.WARNING,
							buttons: Ext.MessageBox.OK
							}
						);	
					}
				}
			},
			"Infoblock\\.view\\.InfoblockCreateWindow[name='Infoblock'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				button.up("window").down("ckeditor").setValue("");
				}
			},
			"Infoblock\\.view\\.InfoblockCreateWindow[name='Infoblock'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);
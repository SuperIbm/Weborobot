Ext.define('Infoblock.controller.InfoblockUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "InfoblockUpdate",
	
	views: ["InfoblockUpdateWindow"],
	stores: ['Infoblock'],
	
		routes:
		{
			"infoblockUpdateTab/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Infoblock").isLoaded() == false)
					{
						this.getStore("Infoblock").on("load",
							function()
							{
							action.resume();	
							},
							null,
							{
							single: true	
							}
						);
					}
					else action.resume();
				},
				action: function(id)
				{
					if(this.getTabUpdate()) this.getTabUpdate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabUpdate: "Infoblock\\.view\\.InfoblockUpdateWindow[name='Infoblock'] Infoblock\\.view\\.InfoblockUpdateTab[name='Infoblock']"
		},
	
		control:
		{			
			"Infoblock\\.view\\.InfoblockUpdateWindow[name='Infoblock'] Infoblock\\.view\\.InfoblockUpdateTab[name='Infoblock']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "infoblockUpdateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"Infoblock\\.view\\.InfoblockUpdateWindow[name='Infoblock'] button[action=send]":
			{
				click: function(button)
				{
				var thisObj = this;

					if(button.up("window").down("form").isValid() == true)
					{
					button.up("window").mask(thisObj.maskLoad);
					
					var data = button.up("window").down("form").getValues();
					data["idInfoblock"] = button.up("window").down("form").getRecord().getId();
					data["code"] = button.up("window").down("ckeditor").getValue();	
					
					var Infoblock = Ext.create(this.getModel("Infoblock"), data);															
						
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
									
								thisObj.getStore("Infoblock").load();
								},
								failure: function(model, operation)
								{
								var result = Ext.decode(operation.getResponse().responseText);
								button.up("window").unmask();
									
									if(result.errormsg)
									{
										Ext.Msg.show
										(
											{
											title: thisObj.error,
											msg: result.errormsg,
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
			"Infoblock\\.view\\.InfoblockUpdateWindow[name='Infoblock'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				button.up("window").down("ckeditor").setValue(form.getRecord().get("code"));
				}
			},
			"Infoblock\\.view\\.InfoblockUpdateWindow[name='Infoblock'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);
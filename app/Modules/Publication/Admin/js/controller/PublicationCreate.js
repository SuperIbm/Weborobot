Ext.define('Publication.controller.PublicationCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationCreate",
	
	views: ["PublicationCreateWindow"],
	stores: ['Publication', 'PublicationSection', 'PublicationImage'],
	
		routes:
		{
			"publicationCreateTab/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("PublicationSection").isLoaded() == false)
					{
						this.getStore("PublicationSection").on("load",
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
				this.getTabCreate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabCreate: "Publication\\.view\\.PublicationCreateWindow[name='Publication'] Publication\\.view\\.PublicationCreateTab[name='Publication']"
		},
	
		control:
		{			
			"Publication\\.view\\.PublicationCreateWindow[name='Publication'] Publication\\.view\\.PublicationCreateTab[name='Publication']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationCreateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"Publication\\.view\\.PublicationCreateWindow[name='Publication'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					button.up("window").mask("Загрузка...");					
					var Publication = Ext.create(this.getModel("Publication"));
					
						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: Publication.getProxy().getApi()["create"],
								params:
								{
								idPublicationSection: button.up("window").down("form").getForm().id,
								textOfArticle: button.up("window").down("ckeditor").getValue()
								},
								success: function(form, action)
								{
								button.up("window").unmask();
								
									Ext.Msg.show
									(
										{
										title: "Данные добавлены!",
										msg: "Введенные вами данные были удачно добавлены!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
									
								thisObj.getStore("Publication").load();
								button.up("window").down("ckeditor").setValue("");
								button.up("window").down("form").reset();
								},
								failure: function(form, action)
								{							
								button.up("window").unmask();
									
									if(action.result.errortype == "isExist")
									{
										Ext.Msg.show
										(
											{
											title: "Ошибка!",
											msg: "Вы не можете добавить публикацию с такой ссылкой, т.к. она уже есть в базе данных!",
											icon: Ext.MessageBox.WARNING,
											buttons: Ext.MessageBox.OK
											}
										);
									}
									else if(action.result.errormsg)
									{
										Ext.Msg.show
										(
											{
											title: "Ошибка!",
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
											title: "Ошибка!",
											msg: "Произошла ошибка выполнения программы на сервере!",
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
							title: "Предупреждение!",
							msg: "Некоторые поля в форме заполнены некорректно!",
							icon: Ext.MessageBox.WARNING,
							buttons: Ext.MessageBox.OK
							}
						);	
					}
				}
			},
			"Publication\\.view\\.PublicationCreateWindow[name='Publication'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				button.up("window").down("ckeditor").setValue("");
				}
			},
			"Publication\\.view\\.PublicationCreateWindow[name='Publication'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);
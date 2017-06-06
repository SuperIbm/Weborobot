Ext.define('Publication.controller.PublicationUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationUpdate",
	
	views: ["PublicationUpdateWindow"],
	stores: ['Publication', 'PublicationCommentTree'],
	models: ['PublicationCommentTree'],

		routes:
		{
			"publicationUpdateTab/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Publication").isLoaded() == false)
					{
						this.getStore("Publication").on("load",
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
		tabUpdate: "Publication\\.view\\.PublicationUpdateWindow[name='Publication'] Publication\\.view\\.PublicationUpdateTab[name='Publication']"
		},
	
		control:
		{			
			"Publication\\.view\\.PublicationUpdateWindow[name='Publication'] Publication\\.view\\.PublicationUpdateTab[name='Publication']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationUpdateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"Publication\\.view\\.PublicationUpdateWindow[name='Publication'] button[action=send]":
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
							url: Publication.getProxy().getApi()["update"],
								params: 
								{
								idPublication: button.up("window").down("form").getRecord().getId(),
								textOfArticle: button.up("window").down("ckeditor").getValue(),
								isDeleteQueryWords: true
								},
								success: function(form, action)
								{
								button.up("window").unmask();
									
									Ext.Msg.show
									(
										{
										title: "Данные изменены!",
										msg: "Введенные вами данные были удачно изменены!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
									
								thisObj.getStore("Publication").load();
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
			"Publication\\.view\\.PublicationUpdateWindow[name='Publication'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				button.up("window").down("ckeditor").setValue(form.getRecord().get("textOfArticle"));
				}
			},
			"Publication\\.view\\.PublicationUpdateWindow[name='Publication'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);
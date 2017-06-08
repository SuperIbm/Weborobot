/**
 * Класс работы с панелью административной системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
var Admin = Ext.application
(
	{
	name: 'Admin',
	
	appFolder: 'app/Modules/Admin/Admin/js',
	controllers: ['Enter', 'App'],

	locals: ["ru", "en"],

		uses:
		[
		"Admin.view.Locale"
		],

		requires:
		[
		"Admin.view.ux.Application",
		"Admin.view.ux.GridPanel",
		"Admin.view.ux.TreePanel",
		"Admin.view.ux.ImagePanel",
		"Admin.view.ux.ImagesZone",
		"Admin.view.ux.ComboBox",
		"Admin.view.ux.ComboBoxStatus",
		"Admin.view.ux.TriggerField",
		"Admin.view.ux.TriggerFieldGeneratePassword",
		"Admin.view.ux.CKEditor",
		"Admin.view.ux.Codemirror",
		"Admin.view.ux.TextMasked",
		"Admin.view.ux.TextPrice",
		"Admin.view.ux.ColorPicker",
		"Admin.view.ux.MenuPanel",
		"Admin.view.ux.PanelAnimateDropZone",
		"Admin.view.ux.PanelColumnAnimate",
		"Admin.view.ux.PanelPortletAnimate",
		"Admin.view.ux.PanelAnimate",
		"Admin.view.ux.BreadCrumb",
		"Admin.view.ux.TreePicker",
		"Admin.view.ux.MapPicker",
		"Admin.view.ux.GridFilters",
		"Admin.view.ux.ColumnWidget",
		"Admin.view.ux.LinkPicker",
		"Admin.view.ux.GridFiltersList",
		"Admin.view.ux.GridFiltersImage",
		"Admin.view.ux.GridFiltersDocument"
		],
		
		Access:
		{
		_Config: null,
		
			_setConfig: function(config)
			{
			Admin.getApplication().Access._Config = config;
			return Admin.getApplication().Access;
			},
			getConfig: function()
			{
			return Admin.getApplication().Access._Config;
			},
            getModules: function(module)
            {
                if(module)
                {
                    if(Admin.getApplication().Access._Config["modules"][module]) return Admin.getApplication().Access._Config["modules"][module];
                }
                else return Admin.getApplication().Access._Config["modules"];
            },
			getSections: function(index)
			{
				if(index)
				{
					if(Admin.getApplication().Access._Config["sections"][index]) return Admin.getApplication().Access._Config["sections"][index];
					else return false;
				}
				else
				{
				return Admin.getApplication().Access._Config["sections"];
				}
			},
			getComponents: function(module, component)
			{
				if(module && component)
				{
					if(Admin.getApplication().Access._Config["modules"][module])
					{
						if(Admin.getApplication().Access._Config["modules"][module]["components"])
						{
                            if(Admin.getApplication().Access._Config["modules"][module]["components"][component]) return Admin.getApplication().Access._Config["modules"][module]["components"][component];
                        }
					}
				}

            return false;
			},
            getWidgets: function(module, widget)
            {
                if(module && widget)
                {
                    if(Admin.getApplication().Access._Config["modules"][module])
                    {
                        if(Admin.getApplication().Access._Config["modules"][module]["widgets"])
                        {
                            if(Admin.getApplication().Access._Config["modules"][module]["widgets"][widget]) return Admin.getApplication().Access._Config["modules"][module]["widgets"][widget];
                        }
                    }
                }

            return false
            },
			getUser: function(index)
			{			
				if(index)
				{
					if(Admin.getApplication().Access._Config["user"][index]) return Admin.getApplication().Access._Config["user"][index];
					else return null;
				}
				else return Admin.getApplication().Access._Config["user"];
			},
			getUserImage: function()
			{
				if(Admin.getApplication().Access._Config["user"]["idImageSmall"])
				{
					if(Admin.getApplication().Access._Config["user"]["idImageSmall"]) return Admin.getApplication().Access._Config["user"]["idImageSmall"];
				}
				
			return false;
			},
			getGroups: function()
			{
				if(Admin.getApplication().Access._Config["groups"])
				{
					return Admin.getApplication().Access._Config["groups"];
				}
			
			return false
			},
			getPages: function()
			{
				if(Admin.getApplication().Access._Config["pages"]) return Admin.getApplication().Access._Config["pages"];
			
			return false
			},
			getPagesUpdate: function()
			{
				if(Admin.getApplication().Access._Config["pagesUpdate"]) return Admin.getApplication().Access._Config["pagesUpdate"];
			
			return false
			},
			getRoles: function()
			{
				if(Admin.getApplication().Access._Config["roles"]) return Admin.getApplication().Access._Config["roles"];
			
			return false
			},
			has: function(type, value)
			{
            var data;

				if(type == "role") data = Admin.getApplication().Access.getRoles();
				else if(type == "page") data = Admin.getApplication().Access.getPages();
				else if(type == "group") data = Admin.getApplication().Access.getGroups();
				else if(type == "pageUpdate") data = Admin.getApplication().Access.getPagesUpdate();
				
				for(var i = 0; i < data.length; i++)
				{
                if(data[i] == value) return true;
				}
				
			return false;
			},
			is: function(index, access)
			{
				if(Admin.getApplication().Access._Config["sections"])
				{	
					if(Admin.getApplication().Access._Config["sections"][index])
					{
                    return Admin.getApplication().Access._Config["sections"][index][access];
					}
				}
			
			return false
			},
			getSetting: function(index)
			{
				if(index)
				{
					if(Admin.getApplication().Access._Config["settings"][index]) return Admin.getApplication().Access._Config["settings"][index];
					else return false;
				}
				else return Admin.getApplication().Access._Config["settings"];
			},
			getLocale: function()
			{
			return Admin.view.Locale;
			},
			exit: function()
			{
			Admin.getApplication().App.getViewport().mask("Загрузка...");
				
				Ext.Ajax.request
				(
					{
					url: '_api/Access/AccessAdminController/logout/',
					method: "POST",
						success: function(response, options)
						{
						var jsonObj = Ext.util.JSON.decode(response.responseText);
						
							if(jsonObj["success"] == true)
							{
								Ext.WindowManager.each
								(
									function(win)
									{														
										if(win.close) win.close();
									}
								);
							
							Admin.getApplication().App.getViewport().unmask();
							Admin.getApplication().App.getViewport().destroy();
							
							Admin.getApplication().Enter._setViewport(new Admin.view.EnterViewport());
							Admin.getApplication().Enter._setWindow(new Admin.view.EnterWindow());
						
							Admin.getApplication().Enter.getWindow().show();
							}
							else
							{
							Admin.getApplication().App.getViewport().unmask();
							
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
						},
						failure: function(response, options)
						{
						Admin.getApplication().App.getViewport().unmask();
						
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
				);	
			}
		},
		Section:
		{
		_Menu: {},
		
		_sectionCurrent: null,
		_menuCurrent: null,
		
			set: function(index, text, bundle, iconSmall, iconBig, menuLeft, pathToJs, pathToCss)
			{
				if(!this.has(index)) Admin.getApplication().Section._Menu[index] = {};
			
				Admin.getApplication().Section._Menu[index] = 
				{
				text: text,
				bundle: bundle,
				iconSmall: iconSmall,
				iconBig: iconBig,
				pathToCss: pathToCss,
				pathToJs: pathToJs,
				menuLeft: menuLeft
				};

			Ext.Loader.setPath(index, pathToJs + '?');

				if(pathToCss) $('HEAD').append('<link type="text/css" rel="stylesheet" href="' + pathToCss + '" />');
			
			return this;
			},
			delete: function(index)
			{
				if(!index)
				{
				Admin.getApplication().Section._Menu = {};
				return this;
				}
				
				if(this.has(index))
				{
				delete Admin.getApplication().Section._Menu[index];
				return this;
				}
			
			return false;
			},
			runRoot: function()
			{
			var ComponentOld = Admin.getApplication().App.getContent().getComponent(0);
			
				if(ComponentOld) if(ComponentOld.itemId == "AppRoot") return ComponentOld;
			
			Admin.getApplication().App.getDesctop().mask("Загрузка...");
			var Panel = Ext.create('Admin.view.AppRoot');
			
				if(ComponentOld) ComponentOld.destroy();

			Admin.getApplication().App.getContent().add(Panel);
			Admin.getApplication().App.getDesctop().unmask();
			
			return Panel;	
			},
			runMenu: function(index)
			{				
			var Panel = Admin.getApplication().App.getMenu().up("viewport").down("panel[bundle='" + index +"']");
			
				if(Panel)
				{
				var childNodes = Panel.down("treepanel").getStore().getRoot().childNodes;
				var data = [];
				
					for(var i = 0; i < childNodes.length; i++)
					{
					data[i] = childNodes[i].getData();
					}
				
					var Menu = Ext.create
					(
						{
						xtype: "panel",
						title: "Подразделы",
						frame: true,
						border: false,
						bodyPadding: 20,
							items:
							[
								{
								xtype: "menuPanel",
								itemId: "menuSub",
									store: Ext.create("Ext.data.Store",
										{
										autoLoad: true,
										fields: ['text', 'iconBig'],
										data: data
										}
									),
									listeners:
									{
										itemclick: function(view, record, item, index, e, eOpts)
										{
										Ext.util.History.add("section/" + record.getId());
										}
									}
								}
							]
						}
					);
								
				var ComponentOld = Admin.getApplication().App.getContent().getComponent(0);
					
					if(ComponentOld) ComponentOld.destroy();
				
				Admin.getApplication().App.getContent().add(Menu);
				
				return Menu;
				}
				else
				{					
					Ext.Msg.show
					(
						{
						title: "Ошибка!",
						msg: "Обработчик для этого модуля не определен!",
						icon: Ext.MessageBox.ERROR,
						buttons: Ext.MessageBox.OK
						}
					);
					
				return false;
				}
			},
			runSection: function(index)
			{
				if(this.has(index) && Admin.getApplication().Access.is(index, "isRead") == true)
				{
				var ComponentOld = Admin.getApplication().App.getContent().getComponent(0);
					
					if(ComponentOld) if(ComponentOld.itemId == index) return ComponentOld;
									
				Admin.getApplication().App.getDesctop().mask("Загрузка...");
				
					try
					{
						var Panel = Ext.create(index + ".view.Panel",
							{
							itemId: index
							}
						);

						if(ComponentOld) ComponentOld.destroy();

					Admin.getApplication().App.getContent().add(Panel);
					Admin.getApplication().App.getDesctop().unmask();
					
					return Panel;
					}
					catch(er)
					{						
					Admin.getApplication().App.getDesctop().unmask();
					
						Ext.Msg.show
						(
							{
							title: "Ошибка JavaScript!",
							msg: er.message + "<br /><br />Название файла: " + er.fileName  + "<br />Номер строки: " + er.lineNumber,
							icon: Ext.MessageBox.ERROR,
							buttons: Ext.MessageBox.OK
							}
						);
						
					return false;
					}
				}
			
			return false;
			},
			selectMenu: function(index, silent)
			{
				if(Admin.getApplication().Section.getMenuCurrent() != index && Admin.getApplication().App.getMenu())
				{
				silent = silent == undefined ? false : silent;
				
				Admin.getApplication().Section.setSection();
				Admin.getApplication().Section.setMenuCurrent(index);
					
				var Panel = Admin.getApplication().App.getMenu().up("viewport").down("panel[bundle='" + index +"']");
				
					if(Panel)
					{
					Panel.expand();
					Admin.getApplication().Section.deselectAll();
					
					var NodeSelect = Admin.getApplication().App.getBreadCrumb().findNode("bundleName", index);
							
						if(NodeSelect) Admin.getApplication().App.getBreadCrumb().updateSelection(NodeSelect, null, true);
					
						if(silent == false) return Admin.getApplication().Section.runMenu(index);
						else return true;
					}
				}
				
			return false;
			},
			selectSection: function(index, silent)
			{
            var NodeSelect;

				if(Admin.getApplication().Section.getSection() != index && Admin.getApplication().App.getMenu() && (Admin.getApplication().Access.is(index, "isRead") == true || index == "root"))
				{		
				silent = silent == undefined ? false : silent;
				
				Admin.getApplication().Section.setSection(index);
				Admin.getApplication().Section.setMenuCurrent();
				
					if(index == "root")
					{					
					Admin.getApplication().Section.deselectAll();
					NodeSelect = Admin.getApplication().App.getBreadCrumb().getStore().getRoot();
							
						if(NodeSelect) Admin.getApplication().App.getBreadCrumb().updateSelection(NodeSelect, null, true);
						
						if(silent == false) return Admin.getApplication().Section.runRoot();	
						else return true;
					}
					else
					{
					var menu = Admin.getApplication().Section.get(index);
					
						if(menu)
						{
						var bandles = Admin.getApplication().Section.getBandles();
						var bandleName = "";
						
							for(var i = 0; i < bandles.length; i++)
							{
								if(menu["bundle"] == bandles[i]["label"])
								{
								bandleName = bandles[i]["name"];
								break;
								}
							}
						
						Admin.getApplication().Section.deselectAll();
						var Panel = Admin.getApplication().App.getMenu().up("viewport").down("panel[bundle=" + bandleName + "]");	
						
							if(Panel)
							{
							Panel.expand();
							
							NodeSelect = Panel.down("treepanel").getStore().findNode("id", index);
							
								if(NodeSelect) Panel.down("treepanel").getSelectionModel().select(NodeSelect, null, true);	
							}
							
						NodeSelect = Admin.getApplication().App.getBreadCrumb().findNode("id", index);
							
							if(NodeSelect)
							{
							Admin.getApplication().App.getBreadCrumb().updateSelection(NodeSelect, null, true);
							}
							
							if(silent == false) return Admin.getApplication().Section.runSection(index);
							else return true;
						}
					}
				}
				
			return false;
			},
			get: function(index)
			{
				if(index)
				{
					if(this.has(index)) return Admin.getApplication().Section._Menu[index];
					else return false;
				}
				else
				{
				return Admin.getApplication().Section._Menu;
				}
			},
			has: function(index)
			{
				if(Admin.getApplication().Section._Menu[index]) return true;
				else return false;
			},
			deselectAll: function()
			{
				if(Admin.getApplication().App.getMenu())
				{
				var bandles = Admin.getApplication().Section.getBandles();
					
					for(var i = 0; i < bandles.length; i++)
					{
					var BundlePanel = Admin.getApplication().App.getMenu().up("viewport").down("panel[bundle=" + bandles[i]["name"] + "]");
					
						if(BundlePanel) BundlePanel.down("treepanel").getSelectionModel().deselectAll();
					}
				}
				
			return this;
			},
			getBandles: function()
			{
				var bundles =
				[
					{
					label: "Контент",
					name: "CONTENT",
					iconCls: "bundle_content"
					},
					{
					label: "Сервисы",
					name: "SERVICES",
					iconCls: "bundle_services"
					},
					{
					label: "Продажи",
					name: "SALES",
					iconCls: "bundle_sales"
					},
					{
					label: "Продвижение",
					name: "SEO",
					iconCls: "bundle_maneger"
					},
					{
					label: "Управление",
					name: "MANEGER",
					iconCls: "bundle_seo"
					},
					{
					label: "Система",
					name: "SYSTEM",
					iconCls: "bundle_system"
					}
				];

			return bundles;
			},
			getSection: function()
			{
			return this._sectionCurrent;	
			},
			setSection: function(index)
			{
			this._sectionCurrent = index;	
			},
			getMenuCurrent: function()
			{
			return this._menuCurrent;	
			},
			setMenuCurrent: function(index)
			{
			this._menuCurrent = index;	
			}
		},
		Session:
		{			
			set: function(name, value, expires)
			{
			var Dt = new Date();
			Dt.setFullYear(Dt.getFullYear() + 20);
			expires = expires == undefined ? Dt : expires;
			
				if(typeof value == "object") value = Ext.JSON.encode(value);
			
			Ext.util.Cookies.set(name, value, expires);
			return this;
			},
			get: function(name)
			{
			var value = Ext.util.Cookies.get(name);
			return Ext.JSON.decode(value);
			},
			has: function(name)
			{
				if(Ext.util.Cookies.get(name)) return true;
				else return false;
			},
			delete: function(name)
			{
			Ext.util.Cookies.clear(name);
			return this;	
			}
		},
		Widget:
		{
		_Obj: {},
		
			set: function(module, widget, label, icon, pathToJs, pathToCss, def)
			{
			def = def === undefined ? false : def;
			
				if(!Admin.getApplication().Widget._Obj[module]) Admin.getApplication().Widget._Obj[module] = {};
			
				Admin.getApplication().Widget._Obj[module][widget] =
				{
				label: label,
                module: module,
                widget: widget,
				icon: icon,
				def: def
				};

			Ext.Loader.setPath(module + ".widget." + widget, pathToJs + '?');
					
				if(pathToCss) $('HEAD').append('<link type="text/css" rel="stylesheet" href="' + pathToCss + '" />');
				
			return this;
			},
			create: function(module, widget, config)
			{
            var widgetConfig = this.get(module, widget);
				
				if(widgetConfig)
				{
				config = config == undefined ? {} : config;
				
					config = Ext.apply(config,
						{
                        module: module,
                        widget: widget,
						icon: widgetConfig["icon"],
						title: widgetConfig["label"]
						}
					);

				var Widget = Ext.create(module + ".widget." + widget + ".view.Panel", config);
					
					Widget.on("close",
						function()
						{
						var AppRoot = this.up("panel").setInSession();
						return true;
						}
					);
					
					Widget.on("collapse",
						function(panel, opt)
						{
						this.up("panel").setInSession();
						return true;
						}
					);
					
					Widget.on("expand",
						function(panel, opt)
						{
						this.up("panel").setInSession();
						return true;
						}
					);
				
				return Widget;
				}
				
			return false;
			},
			delete: function(module, widget)
			{
				if(!module && !widget)
				{
				Admin.getApplication().Widget._Obj = {};
				return this;
				}
				
				if(Admin.getApplication().Widget._Obj[module] && !widget)
				{
				delete Admin.getApplication().Widget._Obj[module];
				return this;
				}
				
				if(Admin.getApplication().Widget._Obj[module])
				{
					if(Admin.getApplication().Widget._Obj[module][widget])
					{
					delete Admin.getApplication().Widget._Obj[module][widget];
					return this;
					}
				}
				
			return false;
			},
			has: function(module, widget)
			{
				if(Admin.getApplication().Widget._Obj[module])
				{
					if(Admin.getApplication().Widget._Obj[module][widget]) return true;
				}
				
				if(Admin.getApplication().Widget._Obj[module] && !widget) return true;
				
			return false;
			},
			get: function(module, widget)
			{
				if(Admin.getApplication().Widget._Obj[module])
				{
					if(Admin.getApplication().Widget._Obj[module][widget])
					{
					return Admin.getApplication().Widget._Obj[module][widget];
					}
				}
				
			return Admin.getApplication().Widget._Obj;
			}
		},
		Component:
		{
		_Obj: {},
		
			set: function(module, component, bundle, text, pathToJs, pathToCss)
			{
				if(module && component)
				{
					if(!Admin.getApplication().Component._Obj[module]) Admin.getApplication().Component._Obj[module] = {};
				
					Admin.getApplication().Component._Obj[module][component] =
					{
					text: text,
					bundle: bundle,
					pathToJs: pathToJs,
					pathToCss: pathToCss	
					};
				
				Ext.Loader.setPath(module + ".component." + component, pathToJs + '?');
					
					if(pathToCss) $('HEAD').append('<link type="text/css" rel="stylesheet" href="' + pathToCss + '" />');
				}
			
			return this;
			},
			run: function(module, component, settings)
			{
				if(this.has(module, component))
				{
				var className = module + ".component." + component + ".view.Window";
				Ext.Loader.loadScriptsSync(Ext.Loader.getPath(className));
				
					if(Ext.ClassManager.get(className))
					{
					var Window = Ext.create(className);	
								
						if(Window.down("form"))
						{
							if(settings) 
							{							
								Window.down("form").on
								(
								"beforerender",
									function()
									{
										if(Window.down("form").setValues) Window.down("form").setValues(settings);
										else Window.down("form").getForm().setValues(settings);	
									},
									null,
									{
									single: true	
									}
								);	
							}
							
						Window.show();
						return Window;
						}
						else return null;	
					}
					else return null;
				}
				else
				{
					Ext.Msg.show
					(
						{
						title: "Ошибка!",
						msg: "Обработчик для этого модуля не определен!",
						icon: Ext.MessageBox.ERROR,
						buttons: Ext.MessageBox.OK
						}
					);
					
				return false;
				}
			},
			delete: function(module, component)
			{
				if(!module && !component)
				{
				Admin.getApplication().Component._Obj = {};
				return this;
				}
				
				if(Admin.getApplication().Component._Obj[module] && !component)
				{
				delete Admin.getApplication().Component._Obj[module];
				return this;
				}
				
				if(Admin.getApplication().Component._Obj[module])
				{
					if(Admin.getApplication().Component._Obj[module][component])
					{
					delete Admin.getApplication().Component._Obj[module][component];
					return this;
					}
				}
				
			return false;
			},
			has: function(module, component)
			{
				if(Admin.getApplication().Component._Obj[module])
				{
					if(Admin.getApplication().Component._Obj[module][component])
					{
					return true;
					}
				}
				
				if(Admin.getApplication().Component._Obj[module] && !component) return true;
				
			return false;
			},
			get: function(module, component)
			{
				if(Admin.getApplication().Component._Obj[module])
				{
					if(Admin.getApplication().Component._Obj[module][component])
					{
					return Admin.getApplication().Component._Obj[module][component];
					}
				}
				
			return Admin.getApplication().Component;
			}
		},
		Enter:
		{
		_Window: null,
		_Viewport: null,
		
		_isReady: false,
		
			_setViewport: function(Viewport)
			{
			Admin.getApplication().Enter._Viewport = Viewport;
			return Admin.getApplication().Enter._Viewport;
			},
			getViewport: function()
			{
			return Admin.getApplication().Enter._Viewport;	
			},
			
			_setWindow: function(Window)
			{
			Admin.getApplication().Enter._Window = Window;
			return Admin.getApplication().Enter._Window;
			},
			getWindow: function()
			{
			return Admin.getApplication().Enter._Window;	
			},
			
			isReady: function(state)
			{
				if(state == undefined) return this._isReady;
				else this._isReady = state;
			},
			onReady: function()
			{
			var oldReady = this._isReady;
			this._isReady = true;
			
				if(Admin.getApplication().Enter.ready && oldReady == false) return Admin.getApplication().Enter.ready.call(this);	
			
			return false;
			}
		},
		App:
		{
		_Desctop: null,
		_Viewport: null,
		_Menu: null,
		_MenuLeft: null,
		_Header: null,
		_BreadCrumb: null,
		_Content: null,
		
		_isReady: false,
		
			_setDesctop: function(Desctop)
			{
			Admin.getApplication().App._Desctop = Desctop;
			return Admin.getApplication().App._Desctop;
			},
			getDesctop: function()
			{
			return Admin.getApplication().App._Desctop;	
			},
			
			_setBreadCrumb: function(BreadCrumb)
			{
			Admin.getApplication().App._BreadCrumb = BreadCrumb;
			return Admin.getApplication().App._BreadCrumb;
			},
			getBreadCrumb: function()
			{
			return Admin.getApplication().App._BreadCrumb;	
			},
			
			_setViewport: function(Viewport)
			{
			Admin.getApplication().App._Viewport = Viewport;			
			return Admin.getApplication().App._Viewport;	
			},
			getViewport: function()
			{
			return Admin.getApplication().App._Viewport;	
			},
			
			_setMenu: function(Menu)
			{
			Admin.getApplication().App._Menu = Menu;
			return Admin.getApplication().App._Menu;		
			},
			getMenu: function()
			{
			return Admin.getApplication().App._Menu;	
			},
			
			_setMenuLeft: function(MenuLeft)
			{
			Admin.getApplication().App._MenuLeft = MenuLeft;
			return Admin.getApplication().App._MenuLeft;		
			},
			getMenuLeft: function()
			{
			return Admin.getApplication().App._MenuLeft;	
			},
			
			_setHeader: function(Header)
			{
			Admin.getApplication().App._Header = Header;
			return Admin.getApplication().App._Header;		
			},
			getHeader: function()
			{
			return Admin.getApplication().App._Header;	
			},
			
			_setContent: function(Content)
			{
			Admin.getApplication().App._Content = Content;
			return Admin.getApplication().App._Content;		
			},
			getContent: function()
			{
			return Admin.getApplication().App._Content;	
			},
			
			_setFooter: function(Footer)
			{
			Admin.getApplication().App._Footer = Footer;
			return Admin.getApplication().App._Footer;		
			},
			getFooter: function()
			{
			return Admin.getApplication().App._Footer;	
			},
			
			isReady: function(state)
			{
				if(state == undefined) return this._isReady;
				else this._isReady = state;
			},
			onReady: function()
			{
			var oldReady = this._isReady;
			this._isReady = true;
			
				if(Admin.getApplication().App.ready && oldReady == false) return Admin.getApplication().App.ready.call(this);	
			
			return false;
			}
		},
		getPathToIcoByFormat: function(format)
		{
		var folderToImage = "app/Modules/Filesystem/Admin/images/";
						
			switch(format)
			{
			case "rar": return folderToImage + "icon_page_zip.png"; 	
			case "zip": return folderToImage + "icon_page_zip.png";
				
			case "rtf": return folderToImage + "icon_page_doc.png"; 	
			case "doc": return folderToImage + "icon_page_doc.png"; 	
			case "docx": return folderToImage + "icon_page_doc.png";
			case 'ppt': return folderToImage + "icon_page_ppt.png";
			 
			case "pdf": return folderToImage + "icon_page_pdf.png";
			case "psd": return folderToImage + "icon_page_pdf.png";
				
			case "csv": return folderToImage + "icon_page_pdf.png"; 								
			case "xls": return folderToImage + "icon_page_pdf.png";  	
			case "xlsx": return folderToImage + "icon_page_pdf.png";
			 
			case "txt": return folderToImage + "icon_page_txt.png"; 
			
			case "jpg": return folderToImage + "icon_page_picture.png";  
			case "jpeg": return folderToImage + "icon_page_picture.png";   
			case "png": return folderToImage + "icon_page_picture.png";   
			case "gif": return folderToImage + "icon_page_picture.png";   
			case "tiff": return folderToImage + "icon_page_picture.png";   
			case "svg": return folderToImage + "icon_page_swf.png";  
			case "swf": return folderToImage + "icon_page_swf.png"; 
			case "flv": return folderToImage + "icon_page_swf.png";  
			case "ico": return folderToImage + "icon_page_picture.png";  
			case "bmp": return folderToImage + "icon_page_picture.png"; 
			
			case "html": return folderToImage + "icon_page_html.png"; 
			case "htm": return folderToImage + "icon_page_html.png"; 
			case "css": return folderToImage + "icon_page_css.png"; 
			case "xml": return folderToImage + "icon_page_html.png"; 
			
			case "mp3": return folderToImage + "icon_page_music.png"; 
			case "mov": return folderToImage + "icon_page_video.png";
			
			case "ttf": return folderToImage + "icon_page_font.png";
			case "js": return folderToImage + "icon_page_js.png";
			case "php": return folderToImage + "icon_page_php.png";	
			case "sql": return folderToImage + "icon_page_sql.png";	
			case "tpl": return folderToImage + "icon_page_tpl.png";	
			case "tmp": return folderToImage + "icon_page_tmp.png";	
			
			default: return 'app/Modules/Admin/Admin/images/icon_page.png';
			}	
		},
		launch: function()
		{
		var thisObj = this;
		Ext.tip.QuickTipManager.init();

			Ext.Error.handle = function(err)
			{
				Ext.Msg.show
				(
					{
					title: "Ошибка JavaScript!",
					msg: err.msg + "<br /><br />Вызываемый класс: " + err.sourceClass + "<br />Вызываемый метод: " + err.sourceMethod,
					icon: Ext.MessageBox.ERROR,
					buttons: Ext.MessageBox.OK
					}
				);
			};

			if(this.locals)
			{
			var Locale = Admin.getApplication().Access.getLocale();
			var localHas = false;

				for(var i = 0; i < this.locals.length; i++)
				{
					if(this.locals[i] == Locale.get())
					{
						localHas = true;
						break;
					}
				}

				if(localHas == true)
				{
				var appFolder = Ext.Loader.getPath(this.getName());

					Locale.load
					(
					appFolder + "/locale/" + Locale.get() + ".js",
						function(success)
						{
							if(success == false)
							{
								Ext.Msg.show
								(
									{
									title: "Ошибка!",
									msg: "Произошла ошибка подгрузки файла локали.",
									icon: Ext.MessageBox.ERROR,
									buttons: Ext.MessageBox.OK
									}
								);
							}
						}
					);
				}
			}

			
			Number.prototype.round = function(number)
			{
				if(number > 0)
				{
				var ost = this - Math.floor(this);
					
					if(ost > 0) return this.toFixed(number);
				}
			
			return this;
			};
			
			//Введем некоторые типы которые нам понядобяться для работы
			Ext.define("Admin.field.array",
				{
				extend: 'Ext.data.field.Field',
				alias: 'data.field.array',				
					convert: function(v, data)
					{
					var strVal = "";
				
						for(var i = 0; i < v.length; i++)
						{
							if(strVal != "") strVal += ", ";
						
						strVal += v[i];
						}
					
					return strVal;
					}
				}
			);
			
			
			Ext.define("Admin.field.object",
				{
				extend: 'Ext.data.field.Field',
				alias: 'data.field.object',

					convert: function(v, data)
					{
					return v;
					}
				}
			);

			Ext.define("Ext.grid.column.Image",
				{
				extend: 'Ext.grid.column.Column',
				alias: 'widget.imagecolumn',

					defaultRenderer: function(value, cellValues)
					{
						if(value)
						{
							if(typeof value == "object")
							{
							return "<img src='" + value.path + "' width='" + value.width + "' height='" + value.height + "' />";
							}
							else return value;
						}
						else return "";
					}
				}
			);

			Ext.define("Ext.grid.column.Document",
				{
					extend: 'Ext.grid.column.Column',
					alias: 'widget.documentcolumn',

					defaultRenderer: function(value, cellValues)
					{
						if(value)
						{
							if(typeof value == "object")
							{
							var pathIcon = Admin.getApplication().getPathToIcoByFormat(value.format);
							return "<a href='" + value.path + "' target='_blank'><img src='" + pathIcon + "' /></a>";
							}
							else return value;
						}
						else return "";
					}
				}
			);
		
			Ext.define("Admin.field.image",
				{
				extend: 'Ext.data.field.Field',
				alias: 'data.field.image',

					convert: function(v, data)
					{
					return v;
					},
					convertSend: function(v, data)
					{
						if(v) return v["id_image"];
						else return null;
					}
				}
			);
			
			Ext.define("Admin.field.document",
				{
				extend: 'Ext.data.field.Field',
				alias: 'data.field.document',

					convert: function(v, data)
					{
					return v;
					},
					convertSend: function(v, data)
					{
						if(v) return v["id_document"];
						else return null;
					}
				}
			);
			
			
			Ext.define("Admin.field.price",
				{
				extend: 'Ext.data.field.Field',
				alias: 'data.field.price',
				
					convert: function(v, data)
					{	
						if(v) return Weborobot.Util.getMoney(v);
						else return "Бесплатно";
					}
				}
			);
			
			
			Ext.define
			(
			"Ext.data.writer.Cgi",
				{
				extend: "Ext.data.writer.Writer",
				alternateClassName: 'Ext.data.CgiWriter',
				alias: 'writer.cgi',
				
					writeRecords: function(request, data)
					{
					var transform = this.getTransform();
						
						if(transform)
						{
						data = transform(data, request);
						request.setParams(data);
						}
						
					request.setParams(data[0]);					
					return request;
					}
				}
			);
			
			Ext.util.History.deleteToken = function(index)
			{
				if(Ext.util.History.getToken() != "" && Ext.util.History.getToken() != "#")
				{				
					if(typeof index == "string") index = [index];
					
				var token = Ext.util.History.getToken().split("|");
					
					if(index.length)
					{						
					var newTokenArray = Ext.util.History.getToken().split("|");
						
						for(var z = 0; z < index.length; z++)
						{
							for(var i = 0; i < token.length; i++)
							{
								if(index[z] == token[i].split("/")[0])
								{
								delete newTokenArray[i];
								}
							}
						}
						
					var newToken = "";
						
						for(var i = 0; i < newTokenArray.length; i++)
						{
							if(newTokenArray[i])
							{
								if(newToken != "") newToken += "|";
							
							newToken += newTokenArray[i];
							}
						}
						
					return newToken;
					}
					else return Ext.util.History.getToken();
				}
				
			return "";
			};
			
			Ext.util.History.addToToken = function(index, values)
			{
			var token;

				if(typeof index == "string")
				{
					if(typeof values == "string" || values === 0) values = [values];
					
					if(Ext.util.History.hasToken(index) == false)
					{
					token = Ext.util.History.getToken();
					}
					else
					{
					token = Ext.util.History.deleteToken(index);
					}				
				
				token += "|" + index;
					
					if(values) token += "/" + values.join("/");
				
				return token;

				}
				else if(typeof index == "object")
				{
				var deleteToken = [];
								
					for(var i = 0; i < index.length; i++)
					{
						if(Ext.util.History.hasToken(index[i]["index"]) == true)
						{
						deleteToken[deleteToken.length] = index[i]["index"];	
						}
					}
					
				token = Ext.util.History.deleteToken(deleteToken);
				
					for(var i = 0; i < index.length; i++)
					{
					token += "|" + index[i]["index"];
						
						if(typeof index[i]['value'] == "object")  token += "/" + index[i]['value'].join("/");
						else if(index[i]['value'] || index[i]['value'] === 0) token += "/" + index[i]['value'];
					}
				
				return token;
				}
				
			return false;
			};
			
			Ext.util.History.hasToken = function(index)
			{
				if(Ext.util.History.getToken() != "" && Ext.util.History.getToken() != "#")
				{
				var token = Ext.util.History.getToken().split("|");
				
					for(var i = 0; i < token.length; i++)
					{
						if(index == token[i].split("/")[0]) return true;
					}
					
				return false;
				}
				
			return false;
			};
			
			Ext.util.History.getTokenValue = function(index, valuePosition)
			{
				if(Ext.util.History.getToken() != "" && Ext.util.History.getToken() != "#")
				{
				valuePosition = valuePosition == undefined ? false : valuePosition;
				var token = Ext.util.History.getToken().split("|");
				
					for(var i = 0; i < token.length; i++)
					{					
						if(index == token[i].split("/")[0])
						{						
							if(valuePosition === false)
							{
							var values = [];
							var valuesToken = token[i].split("/");
							
								for(var z = 1; z < valuesToken.length; z++)
								{
								values[values.length] = valuesToken[z];
								}
								
							return values;
							}
							else return token[i].split("/")[++valuePosition];
						}
					}
				}
				
			return null;
			};

			
			// Делаем запрос и понимаем мы входим в систему или всетаки запрашиваем логин и пароль
			Ext.Ajax.request
			(
				{
				url: '_api/Access/AccessAdminController/gate/',
				method: "GET",
					success: function(response, options)
					{
					var result = Ext.JSON.decode(response.responseText);
					
						if(result["success"] == true)
						{
						Admin.getApplication().Access._setConfig(result["data"]);
						Admin.getApplication().App._setViewport(new Admin.view.AppViewport());
						
						Admin.getApplication().App.onReady();
						}
						else
						{
						Admin.getApplication().Enter._setViewport(new Admin.view.EnterViewport());
						Admin.getApplication().Enter._setWindow(new Admin.view.EnterWindow());
					
						Admin.getApplication().Enter.getWindow().show();
						Admin.getApplication().Enter.onReady();
						}
					},
					failure: function(response, options)
					{		
						Ext.Msg.show
						(
							{
							title: "Ошибка!",
							msg: "Произошла ошибка выполнения программы на сервере!",
							icon: Ext.MessageBox.ERROR,
							buttons: Ext.MessageBox.OK,
								fn: function()
								{
								new Admin.controller.Enter();
								}
							}
						);
					}
				}
			);
		}
	}
);


<!-- <link rel="stylesheet" href="css/perfect-scrollbar.css" />
<link rel="stylesheet" type="text/css" href="css/normalize.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/page-defaults.css" media="screen" /> -->
<link rel="stylesheet" type="text/css" href="css/stx-chart.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/chartiq.css" media="screen" />
<div >
<cq-context>
<cq-ui-manager></cq-ui-manager>
<cq-color-picker>
	<cq-colors></cq-colors>
	<cq-overrides>
		<template>
			<div class="ciq-btn"></div>
		</template>
	</cq-overrides>
</cq-color-picker>

<div class="ciq-nav">
	<cq-menu class="ciq-search">
		<cq-lookup cq-keystroke-claim cq-keystroke-default cq-uppercase>
			<cq-lookup-input cq-no-close>
				<input id="symbol" type="text" spellcheck="off" autocomplete="off" autocorrect="off" autocapitalize="off" name="symbol" placeholder="">
				<cq-lookup-icon></cq-lookup-icon>
			</cq-lookup-input>
			<cq-lookup-results>
				<cq-lookup-filters cq-no-close>
					<cq-filter class="true">ALL</cq-filter>
					<cq-filter>STOCKS</cq-filter>
					<cq-filter>FX</cq-filter>
					<cq-filter>INDEXES</cq-filter>
					<cq-filter>FUNDS</cq-filter>
					<cq-filter>FUTURES</cq-filter>
				</cq-lookup-filters>
				<cq-scroll></cq-scroll>
			</cq-lookup-results>
		</cq-lookup>
	</cq-menu>

	<div class="ciq-menu-section">
		<div class="ciq-dropdowns">
       
			<cq-menu class="ciq-menu ciq-period">
				<span><cq-clickable stxbind="Layout.periodicity">1 D</cq-clickable></span>
				<cq-menu-dropdown>
					<cq-item stxtap="Layout.setPeriodicity(1,1,'day')">1 D</cq-item>
					<cq-item stxtap="Layout.setPeriodicity(1,1,'week')">1 W</cq-item>
					<cq-item stxtap="Layout.setPeriodicity(1,1,'month')">1 Mo</cq-item>
					<cq-separator></cq-separator>
					<cq-item stxtap="Layout.setPeriodicity(1,1,'minute')">1 Min</cq-item>
					<cq-item stxtap="Layout.setPeriodicity(1,5,'minute')">5 Min</cq-item>
					<cq-item stxtap="Layout.setPeriodicity(1,10,'minute')">10 Min</cq-item>
					<cq-item stxtap="Layout.setPeriodicity(3,5,'minute')">15 Min</cq-item>
					<cq-item stxtap="Layout.setPeriodicity(1,30,'minute')">30 Min</cq-item>
					<cq-item stxtap="Layout.setPeriodicity(2,30,'minute')">1 Hour</cq-item>
					<cq-item stxtap="Layout.setPeriodicity(8,30,'minute')">4 Hour</cq-item>
				</cq-menu-dropdown>
			</cq-menu>
			<cq-menu class="ciq-menu ciq-views collapse">
				<span>Views</span>
				<cq-menu-dropdown>
					<cq-views>
						<cq-heading>Saved Views</cq-heading>
						<cq-views-content>
							<template cq-view>
								<cq-item>
									<cq-label></cq-label>
									<div class="ciq-icon ciq-close"></div>
								</cq-item>
							</template>
						</cq-views-content>
						<cq-separator cq-partial></cq-separator>
						<cq-view-save>
							<cq-item><cq-plus></cq-plus>Save View</cq-item>
						</cq-view-save>
					</cq-views>
				</cq-menu-dropdown>
			</cq-menu>
			<cq-menu class="ciq-menu ciq-display collapse">
				<span>Display</span>
				<cq-menu-dropdown>
					<cq-heading>Chart Style</cq-heading>
					<cq-item stxsetget="Layout.ChartType('candle')">Candle<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item stxsetget="Layout.ChartType('bar')">Bar<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item stxsetget="Layout.ChartType('colored_bar')">Colored Bar<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item stxsetget="Layout.ChartType('line')">Line<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item stxsetget="Layout.ChartType('hollow_candle')">Hollow Candle<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item stxsetget="Layout.ChartType('mountain')">Mountain<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item stxsetget="Layout.ChartType('baseline_delta')">Baseline<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item stxsetget="Layout.ChartType('volume_candle')">Volume Candle<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-separator></cq-separator>
					<cq-item>
						<div stxsetget="Layout.ChartType('heikinashi')">Heikin Ashi<span class="ciq-radio"><span></span></span>
						</div>
					</cq-item>
					<cq-item>
						<span class="ciq-edit" stxtap="Layout.showAggregationEdit('kagi')"></span>
						<div stxsetget="Layout.ChartType('kagi')">Kagi<span class="ciq-radio"><span></span></span>
						</div>
					</cq-item>
					<cq-item>
						<span class="ciq-edit" stxtap="Layout.showAggregationEdit('linebreak')"></span>
						<div stxsetget="Layout.ChartType('linebreak')">Line Break<span class="ciq-radio"><span></span></span>
						</div>
					</cq-item>
					<cq-item>
						<span class="ciq-edit" stxtap="Layout.showAggregationEdit('renko')"></span>
						<div stxsetget="Layout.ChartType('renko')">Renko<span class="ciq-radio"><span></span></span>
						</div>
					</cq-item>
					<cq-item>
						<span class="ciq-edit" stxtap="Layout.showAggregationEdit('rangebars')"></span>
						<div stxsetget="Layout.ChartType('rangebars')">Range Bars<span class="ciq-radio"><span></span></span>
						</div>
					</cq-item>
					<cq-item>
						<span class="ciq-edit" stxtap="Layout.showAggregationEdit('pandf')"></span>
						<div stxsetget="Layout.ChartType('pandf')">Point & Figure<span class="ciq-radio"><span></span></span>
						</div>
					</cq-item>
					<cq-separator></cq-separator>
					<cq-heading>Chart Preferences</cq-heading>
					<cq-item stxsetget="Layout.ChartScale('log')">Log Scale<span class="ciq-checkbox ciq-active"><span></span></span>
					</cq-item>
					<cq-item stxsetget="Layout.ExtendedHours()">Extended Hours<span class="ciq-checkbox ciq-active"><span></span></span>
					</cq-item>
					<cq-item stxsetget="Layout.RangeSlider()">Range Selector<span class="ciq-checkbox ciq-active"><span></span></span>
					</cq-item>
					<cq-separator></cq-separator>
					<cq-heading>Locale</cq-heading>
						<cq-item><cq-clickable cq-selector="cq-timezone-dialog" cq-method="open">Change Timezone</cq-clickable></cq-item>
						<cq-item stxsetget="Layout.Language()"><cq-flag></cq-flag><cq-language-name>Change Language</cq-language-name></cq-item>
					<cq-separator></cq-separator>
					<cq-heading>Themes</cq-heading>
					<cq-themes>
						<cq-themes-builtin cq-no-close>
							<template>
								<cq-item></cq-item>
							</template>
						</cq-themes-builtin>
						<cq-themes-custom cq-no-close>
							<template>
								<cq-theme-custom>
									<cq-item>
										<cq-label></cq-label>
										<cq-close></cq-close>
									</cq-item>
								</cq-theme-custom>
							</template>
						</cq-themes-custom>
						<cq-separator cq-partial></cq-separator>
						<cq-item stxtap="newTheme()"><cq-plus></cq-plus>New Theme</cq-item>
					</cq-themes>
				</cq-menu-dropdown>
			</cq-menu>
			<cq-menu class="ciq-menu ciq-studies collapse">
				<span>Studies</span>
				<cq-menu-dropdown cq-no-scroll>
					<cq-study-legend cq-no-close>
						<cq-section-dynamic>
							<cq-heading>Current Studies</cq-heading>
							<cq-study-legend-content>
								<template>
									<cq-item>
										<cq-label class="click-to-edit"></cq-label>
										<div class="ciq-icon ciq-close"></div>
									</cq-item>
								</template>
							</cq-study-legend-content>
							<cq-placeholder>
								<div stxtap="Layout.clearStudies()" class="ciq-btn sm">Clear All</div>
							</cq-placeholder>
						</cq-section-dynamic>
					</cq-study-legend>
					<cq-scroll>
						<cq-studies>
							<cq-studies-content>
									<template>
										<cq-item>
											<cq-label></cq-label>
										</cq-item>
									</template>
							</cq-studies-content>
						</cq-studies>
					</cq-scroll>
				</cq-menu-dropdown>
			</cq-menu>
			<cq-menu class="ciq-menu stx-markers collapse">
				<span>Events</span>
				<cq-menu-dropdown>
					<cq-item class="square">Simple Square<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item class="circle">Simple Circle<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item class="callout">Callouts<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item class="abstract">Abstract<span class="ciq-radio"><span></span></span>
					</cq-item>
					<cq-item class="none">None<span class="ciq-radio ciq-active"><span></span></span>
					</cq-item>
				</cq-menu-dropdown>
			</cq-menu>
		</div>

		<!-- enables the more button when in break-sm mode -->
		<div class="sidenav-toggle ciq-toggles">
			<cq-toggle class="ciq-sidenav" cq-member="sidenav" cq-toggles="sidenavOn,sidenavOff"><span></span>
				<cq-tooltip>More</cq-tooltip>
			</cq-toggle>
		</div>

		<!-- any entry in this div will be shown in the side navigation bar in break-sm mode -->
		<div class="icon-toggles ciq-toggles">
			<cq-toggle class="ciq-CH" cq-member="crosshair"><span></span><cq-tooltip>Crosshair</cq-tooltip></cq-toggle>
			<cq-toggle class="ciq-HU" cq-member="headsUp" cq-toggles="dynamic,static,null"><span></span><cq-tooltip>Info</cq-tooltip></cq-toggle>
			<cq-toggle class="ciq-draw"><span></span><cq-tooltip>Draw</cq-tooltip></cq-toggle>

			<!-- comment in the following line if you are using the TFC plug in -->
			<cq-toggle class="sidebar stx-trade"><span></span><cq-tooltip>Trade</cq-tooltip></cq-toggle>
			<!-- comment in the following line if you are using the tradingcentral plug in -->
			<!-- <cq-toggle class="stx-tradingcentral"><span></span><cq-tooltip>Analysis</cq-tooltip></cq-toggle> -->
		</div>
	</div>
</div>
<!-- End Navbar -->

<!-- comment in the following line if you are using the TFC plug in -->
<cq-tfc></cq-tfc>

<!-- comment in the following line if you are using the tradingcentral plug in -->
<!-- <cq-tradingcentral token="leWp5sKSbV7sENXba2EUXQ==" partner="647" disabled></cq-tradingcentral> -->

<div class="ciq-chart-area">
	<div class="ciq-chart">
		<cq-toolbar>
			<cq-menu class="ciq-select">
				<span cq-current-tool>Select Tool</span>
				<cq-menu-dropdown>
					<cq-item stxtap="noTool()">None</cq-item>
					<cq-item stxtap="clearDrawings()">Clear Drawings</cq-item>
					<cq-item stxtap="tool('measure')">Measure</cq-item>
					<cq-separator></cq-separator>
					<cq-item stxtap="tool('annotation')">Annotation</cq-item>
					<cq-item stxtap="tool('average')">Average Line</cq-item>
					<cq-item stxtap="tool('callout')">Callout</cq-item>
					<cq-item stxtap="tool('channel')">Channel</cq-item>
					<cq-item stxtap="tool('continuous')">Continuous</cq-item>
					<cq-item stxtap="tool('crossline')">Crossline</cq-item>
					<cq-item stxtap="tool('freeform')">Doodle</cq-item>
					<cq-item stxtap="tool('ellipse')">Ellipse</cq-item>
					<cq-item stxtap="tool('retracement')">Fib Retracement</cq-item>
					<cq-item stxtap="tool('fibprojection')">Fib Projection</cq-item>
					<cq-item stxtap="tool('fibarc')">Fib Arc</cq-item>
					<cq-item stxtap="tool('fibfan')">Fib Fan</cq-item>
					<cq-item stxtap="tool('fibtimezone')">Fib Time Zone</cq-item>
					<cq-item stxtap="tool('gannfan')">Gann Fan</cq-item>
					<cq-item stxtap="tool('gartley')">Gartley</cq-item>
					<cq-item stxtap="tool('horizontal')">Horizontal</cq-item>
					<cq-item stxtap="tool('line')">Line</cq-item>
					<cq-item stxtap="tool('pitchfork')">Pitchfork</cq-item>
					<cq-item stxtap="tool('quadrant')">Quadrant Lines</cq-item>
					<cq-item stxtap="tool('ray')">Ray</cq-item>
					<cq-item stxtap="tool('rectangle')">Rectangle</cq-item>
					<cq-item stxtap="tool('regression')">Regression Line</cq-item>
					<cq-item stxtap="tool('segment')">Segment</cq-item>
					<cq-item stxtap="tool('arrow')">Shape - Arrow</cq-item>
					<cq-item stxtap="tool('check')">Shape - Check</cq-item>
					<cq-item stxtap="tool('xcross')">Shape - Cross</cq-item>
					<cq-item stxtap="tool('focusarrow')">Shape - Focus</cq-item>
					<cq-item stxtap="tool('heart')">Shape - Heart</cq-item>
					<cq-item stxtap="tool('star')">Shape - Star</cq-item>
					<cq-item stxtap="tool('speedarc')">Speed Resistance Arc</cq-item>
					<cq-item stxtap="tool('speedline')">Speed Resistance Line</cq-item>
					<cq-item stxtap="tool('timecycle')">Time Cycle</cq-item>
					<cq-item stxtap="tool('tirone')">Tirone Levels</cq-item>
					<cq-item stxtap="tool('trendline')">Trend Line</cq-item>
					<cq-item stxtap="tool('vertical')">Vertical</cq-item>
				</cq-menu-dropdown>
			</cq-menu>
			<cq-toolbar-settings>
				<cq-fill-color cq-section class="ciq-color" stxbind="getFillColor()" stxtap="pickFillColor()">
					<span></span>
				</cq-fill-color>
				<div>
					<cq-line-color cq-section cq-overrides="auto" class="ciq-color" stxbind="getLineColor()" stxtap="pickLineColor()"><span></span></cq-line-color>
					<cq-line-style cq-section>
						<cq-menu class="ciq-select">
							<span cq-line-style class="ciq-line ciq-selected"></span>
							<cq-menu-dropdown class="ciq-line-style-menu">
								<cq-item stxtap="setLine(1,'solid')"><span class="ciq-line-style-option ciq-solid-1"></span></cq-item>
								<cq-item stxtap="setLine(3,'solid')"><span class="ciq-line-style-option ciq-solid-3"></span></cq-item>
								<cq-item stxtap="setLine(5,'solid')"><span class="ciq-line-style-option ciq-solid-5"></span></cq-item>
								<cq-item stxtap="setLine(1,'dotted')"><span class="ciq-line-style-option ciq-dotted-1"></span></cq-item>
								<cq-item stxtap="setLine(3,'dotted')"><span class="ciq-line-style-option ciq-dotted-3"></span></cq-item>
								<cq-item stxtap="setLine(5,'dotted')"><span class="ciq-line-style-option ciq-dotted-5"></span></cq-item>
								<cq-item stxtap="setLine(1,'dashed')"><span class="ciq-line-style-option ciq-dashed-1"></span></cq-item>
								<cq-item stxtap="setLine(3,'dashed')"><span class="ciq-line-style-option ciq-dashed-3"></span></cq-item>
								<cq-item stxtap="setLine(5,'dashed')"><span class="ciq-line-style-option ciq-dashed-5"></span></cq-item>
								<cq-item stxtap="setLine(0,'none')" class="ciq-none">None</cq-item>
							</cq-menu-dropdown>
						</cq-menu>
					</cq-line-style>
				</div>
				<cq-axis-label cq-section>
					<div class="ciq-heading">Axis Label:</div>
					<span stxtap="toggleAxisLabel()" class="ciq-checkbox ciq-active"><span></span></span>
				</cq-axis-label>
				<cq-annotation cq-section>
					<cq-annotation-italic stxtap="toggleFontStyle('italic')" class="ciq-btn" style="font-style:italic;">I</cq-annotation-italic>
					<cq-annotation-bold stxtap="toggleFontStyle('bold')" class="ciq-btn" style="font-weight:bold;">B</cq-annotation-bold>
					<cq-menu class="ciq-select">
						<span cq-font-size>12px</span>
						<cq-menu-dropdown class="ciq-font-size">
							<cq-item stxtap="setFontSize('8px')">8</cq-item>
							<cq-item stxtap="setFontSize('10px')">10</cq-item>
							<cq-item stxtap="setFontSize('12px')">12</cq-item>
							<cq-item stxtap="setFontSize('13px')">13</cq-item>
							<cq-item stxtap="setFontSize('14px')">14</cq-item>
							<cq-item stxtap="setFontSize('16px')">16</cq-item>
							<cq-item stxtap="setFontSize('20px')">20</cq-item>
							<cq-item stxtap="setFontSize('28px')">28</cq-item>
							<cq-item stxtap="setFontSize('36px')">36</cq-item>
							<cq-item stxtap="setFontSize('48px')">48</cq-item>
							<cq-item stxtap="setFontSize('64px')">64</cq-item>
						</cq-menu-dropdown>
					</cq-menu>
					<cq-menu class="ciq-select">
						<span cq-font-family>Default</span>
						<cq-menu-dropdown class="ciq-font-family">
							<cq-item stxtap="setFontFamily('Default')">Default</cq-item>
							<cq-item stxtap="setFontFamily('Helvetica')">Helvetica</cq-item>
							<cq-item stxtap="setFontFamily('Courier')">Courier</cq-item>
							<cq-item stxtap="setFontFamily('Garamond')">Garamond</cq-item>
							<cq-item stxtap="setFontFamily('Palatino')">Palatino</cq-item>
							<cq-item stxtap="setFontFamily('Times New Roman')">Times New Roman</cq-item>
						</cq-menu-dropdown>
					</cq-menu>
				</cq-annotation>
				<cq-clickable cq-fib-settings cq-selector="cq-fib-settings-dialog" cq-method="open" cq-section><span class="ciq-btn">Settings</span></cq-clickable>
			</cq-toolbar-settings>
			<cq-measure><span class="measureUnlit" id="mMeasure"></span></cq-measure>
			<cq-undo-section>
				<cq-undo class="ciq-btn">Undo</cq-undo>
				<cq-redo class="ciq-btn">Redo</cq-redo>
			</cq-undo-section>
		</cq-toolbar>
		<div class="chartContainer" id="chartContainer">

			<stx-hu-tooltip>
				<stx-hu-tooltip-field field="DT">
					<stx-hu-tooltip-field-name>Date/Time</stx-hu-tooltip-field-name>
					<stx-hu-tooltip-field-value></stx-hu-tooltip-field-value>
				</stx-hu-tooltip-field>
				<stx-hu-tooltip-field field="Close">
					<stx-hu-tooltip-field-name></stx-hu-tooltip-field-name>
					<stx-hu-tooltip-field-value></stx-hu-tooltip-field-value>
				</stx-hu-tooltip-field>
			</stx-hu-tooltip>

			<cq-chart-title cq-marker cq-browser-tab>
				<cq-symbol></cq-symbol>
				<cq-chart-price>
					<cq-current-price cq-animate></cq-current-price>
					<cq-change>
						<div class="ico"></div>
						<cq-todays-change></cq-todays-change> (
						<cq-todays-change-pct></cq-todays-change-pct>)
					</cq-change>
				</cq-chart-price>
			</cq-chart-title>
			<cq-comparison cq-marker>
				<cq-menu class="cq-comparison-new">
					<cq-comparison-add-label class="ciq-no-share">
						<cq-comparison-plus></cq-comparison-plus><span>Compare</span><span>...</span>
					</cq-comparison-add-label>
					<cq-comparison-add>
						<cq-comparison-lookup-frame>
							<cq-lookup cq-keystroke-claim cq-uppercase>
								<cq-lookup-input cq-no-close>
									<input type="text" cq-focus spellcheck="off" autocomplete="off" autocorrect="off" autocapitalize="off" placeholder="Enter Symbol">
									<cq-lookup-icon></cq-lookup-icon>
								</cq-lookup-input>
								<cq-lookup-results>
									<cq-lookup-filters cq-no-close>
										<cq-filter class="true">ALL</cq-filter>
										<cq-filter>STOCKS</cq-filter>
										<cq-filter>FX</cq-filter>
										<cq-filter>INDEXES</cq-filter>
										<cq-filter>FUNDS</cq-filter>
										<cq-filter>FUTURES</cq-filter>
									</cq-lookup-filters>
									<cq-scroll></cq-scroll>
								</cq-lookup-results>
							</cq-lookup>
						</cq-comparison-lookup-frame>
						<cq-swatch cq-no-close></cq-swatch>
						<span><cq-accept-btn class="stx-btn">ADD</cq-accept-btn></span>
					</cq-comparison-add>
				</cq-menu>
				<cq-comparison-key>
					<template cq-comparison-item>
						<cq-comparison-item>
							<cq-comparison-swatch></cq-comparison-swatch>
							<cq-comparison-label>AAPL</cq-comparison-label>
							<!-- cq-comparison-price displays the current price with color animation -->
							<cq-comparison-price cq-animate></cq-comparison-price>
							<!-- cq-comparison-tick-price displays the price for the active crosshair item -->
							<!-- <cq-comparison-tick-price></cq-comparison-tick-price>	-->
							<cq-comparison-loader></cq-comparison-loader>
							<div class="stx-btn-ico ciq-close"></div>
						</cq-comparison-item>
					</template>
				</cq-comparison-key>
			</cq-comparison>
				<!--- 	Here is an example of how to create a study legend on the chart.
					We use the cq-marker attribute to ensure that it floats inside the chart.
					We set the optional cq-panel-only attribute so that only studies from
					this panel are displayed.
					-- Comment out if a legend on the chart window is not desired --
			-->
			<cq-study-legend cq-marker-label="Overlays" cq-overlays-only cq-marker cq-hovershow>
				<template>
					<cq-item>
						<cq-label></cq-label>
						<span class="ciq-edit"></span>
						<div class="ciq-icon ciq-close"></div>
					</cq-item>
				</template>
			</cq-study-legend>
			<cq-loader></cq-loader>
			<cq-hu-static>
				<div>
					<div>Price</div><cq-hu-price></cq-hu-price>
					<div>Open</div><cq-hu-open></cq-hu-open>
					<div>Close</div><cq-hu-close></cq-hu-close>
				</div>
				<div>
					<div>Vol</div>
					<cq-volume-section>
						<cq-hu-volume></cq-hu-volume>
						<cq-volume-rollup></cq-volume-rollup>
					</cq-volume-section>
					<div>High</div><cq-hu-high></cq-hu-high>
					<div>Low</div><cq-hu-low></cq-hu-low>
				</div>
			</cq-hu-static>

		</div>
		<!-- End Chart Container -->
	</div>
	<!-- End Chart Box -->
</div>


<!-- End Chart Area -->


<!-- Markers/Events -->
<div class="stx-marker-templates" style="display:none">
	<!-- Callout Markers -->
	<div class="callouts">
		<div class="stx-marker callout" style="left:0px; bottom:60px;">
			<div class="stx-stem"></div>
			<div class="stx-marker-content">
				<h4>This is a callout marker</h4>
				<div class="stx-marker-expand">
					<p>Like all ChartIQ markers, the object itself is managed by the chart, so when you scroll the chart the object moves with you. It is also destroyed automatically for you when the symbol is changed.</p>
				</div>
			</div>
		</div>
		<div class="stx-marker callout" style="left:200px; bottom:60px;">
			<div class="stx-stem"></div>
			<div class="stx-marker-content">
				<h4>This is a callout marker</h4>
				<div class="stx-marker-expand">
					<p>Like all ChartIQ markers, the object itself is managed by the chart, so when you scroll the chart the object moves with you. It is also destroyed automatically for you when the symbol is changed.</p>
				</div>
			</div>
		</div>
		<div class="stx-marker callout" style="left:400px; bottom:60px;">
			<div class="stx-stem"></div>
			<div class="stx-marker-content">
				<h4>This is a callout marker</h4>
				<div class="stx-marker-expand">
					<p>Like all ChartIQ markers, the object itself is managed by the chart, so when you scroll the chart the object moves with you. It is also destroyed automatically for you when the symbol is changed.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- Abstract Markers. You can remove this unless you actually need a helicopter. Seriously though, markers can be anything you want them to be! -->
	<div class="abstract">
		<div class="stx-marker abstract">
			<div class="stx-marker-content">
				<style>
				.stx-marker.abstract {
					width: 0;
					transition: all .2s;
				}

				.stx-marker-content .sample {
					position: absolute;
					bottom: 0;
					margin-left: -67px;
					width: 135px;
					height: 135px;
					background: rgba(255, 255, 255, .1);
					text-align: left;
					border-radius: 50%;
					-webkit-transition: width 0.2s 0s, height 0.2s 0s, border-radius 0.2s 0s, margin 0.2s 0s, background 0.5s;
					transition: width 0.2s 0s, height 0.2s 0s, border-radius 0.2s 0s, margin 0.2s 0s, background 0.5s;
				}

				.sample:hover {
					width: 250px;
					margin-left: -125px;
					border-radius: 5px;
					background: #fff;
					-webkit-transition: width 0.2s .5s, height 0.2s .5s, border-radius 0.2s .5s, margin 0.2s .5s, background 1s;
					transition: width 0.2s .5s, height 0.2s .5s, border-radius 0.2s .5s, margin 0.2s .5s, background 1s;
				}

				.sample .text {
					position: absolute;
					font-size: 11px;
					left: 160px;
					width: 80px;
					bottom: 13px;
					opacity: 0;
					line-height: 13px;
					-webkit-transition: opacity 0s 0s;
					-moz-transition: opacity 0s 0s;
					transition: opacity 0s 0s;
				}

				.sample:hover .text {
					opacity: 1;
					-webkit-transition: opacity 0.4s .7s;
					-moz-transition: opacity 0.4s .7s;
					transition: opacity 0.4s .7s;
				}

				#stage {
					position: absolute;
					left: 10px;
					bottom: 10px;
					width: 115px;
					height: 115px;
					background: #e8e8e8;
					border-radius: 50%;
					-webkit-transition: width 0.2s 0s, height 0.2s 0s, border-radius 0.2s 0s, margin 0.2s 0s, background 0.2s;
					transition: width 0.2s 0s, height 0.2s 0s, border-radius 0.2s 0s, margin 0.2s 0s, background 0.2s;
				}

				.sample:hover #stage {
					width: 135px;
					border-radius: 5px;
					background: #e8e8e8;
					-webkit-transition: width 0.2s .5s, height 0.2s .5s, border-radius 0.2s .5s, margin 0.2s .5s, background 0.2s;
					transition: width 0.2s .5s, height 0.2s .5s, border-radius 0.2s .5s, margin 0.2s .5s, background 0.2s;
				}

				@-webkit-keyframes heli-hover {
					0% {
						-webkit-transform: rotate(0deg) translateY(0px);
					}
					35% {
						-webkit-transform: rotate(6deg) translateY(-70px);
					}
					80% {
						-webkit-transform: rotate(-4deg) translateY(0px);
					}
					100% {
						-webkit-transform: translateY(0px);
					}
				}

				@keyframes heli-hover {
					0% {
						transform: rotate(0deg) translateY(0px);
					}
					35% {
						transform: rotate(6deg) translateY(-70px);
					}
					80% {
						transform: rotate(-4deg) translateY(0px);
					}
					100% {
						transform: translateY(0px);
					}
				}

				#helicopter {
					position: absolute;
					margin-left: -5px;
					margin-bottom: 5px;
					left: -10px;
					bottom: 15px;
					width: 145px;
					height: 55px;
					-webkit-transition: margin 0.75s;
					transition: margin 0.75s;
				}

				.sample:hover #helicopter {
					margin-left: 0px;
					margin-bottom: 0;
					-webkit-animation: heli-hover 6s ease-in-out infinite;
					/* Chrome, Safari, Opera */
					animation: heli-hover 6s ease-in-out infinite;
					/* Standard syntax */
				}

				#propeller {
					position: absolute;
					top: 2px;
					left: 30px;
					width: 0px;
					perspective: 500px;
					-webkit-perspective: 500px;
					z-index: 1;
				}

				@keyframes spinner {
					from {
						transform: rotateY(0deg);
					}
					to {
						transform: rotateY(-360deg);
					}
				}

				@-webkit-keyframes spinner {
					from {
						-webkit-transform: rotateY(0deg);
					}
					to {
						-webkit-transform: rotateY(-360deg);
					}
				}

				#spinner {
					-webkit-animation: spinner 1s linear infinite;
					/* Chrome, Safari, Opera */
					animation: spinner 1s linear infinite;
					/* Standard syntax */
					-webkit-transform-style: preserve-3d;
					transform-style: preserve-3d;
				}

				#spinner div {
					position: absolute;
					background: #999;
					width: 80px;
					height: 4px;
				}

				#heli-body {
					position: absolute;
					left: 0;
					width: 145px;
					height: 55px;
					position: absolute;
					background: url(css/img/helicopter.png) no-repeat center;
					z-index: 2;
				}
				#chartContainer{
					height: 400px !important;
				}
				</style>
				<div class="sample">
					<div id="stage">
						<div id="helicopter">
							<div id="propeller" style="height: 160px;">
								<div id="spinner" style="-webkit-transform-origin: 40px 0 0; transform-origin: 40px 0 0;">
									<div style="-webkit-transform: rotateY(0deg) translateX(40px); transform: rotateY(0deg) translateX(40px);"></div>
									<div style="-webkit-transform: rotateY(-90deg) translateX(40px); transform: rotateY(-90deg) translateX(40px);"></div>
									<div style="-webkit-transform: rotateY(-180deg) translateX(40px); transform: rotateY(-180deg) translateX(40px);"></div>
									<div style="-webkit-transform: rotateY(-270deg) translateX(40px); transform: rotateY(-270deg) translateX(40px);"></div>
								</div>
							</div>
							<div id="heli-body"></div>
						</div>
					</div>
					<div class="text">This is an example of a complex marker which can contain html, video, images, css, and animations.</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Marker/Events -->

<!-- Attribution component -->
<cq-attribution>
	<template>
		<cq-attrib-container>
			<cq-attrib-source></cq-attrib-source>&nbsp;
			<cq-attrib-quote-type></cq-attrib-quote-type>
		</cq-attrib-container>
	</template>
</cq-attribution>


<cq-hu-dynamic>
		<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 215 140" enable-background="new 0 0 215 140" xml:space="preserve">
		<defs>
			<filter id="ciq-hu-shadow" height="130%">
				<feGaussianBlur in="SourceAlpha" stdDeviation="1"/>
				<feOffset dx="0" dy="1" result="offsetblur"/>
				<feComponentTransfer>
					<feFuncA type="linear" slope="0.2"/>
				</feComponentTransfer>
				<feMerge>
					<feMergeNode/>
					<feMergeNode in="SourceGraphic"/>
				</feMerge>
			</filter>
		</defs>
		<polygon class="ciq-hu-bg" fill="#2A51D0" points="198.4,124.4 1,124.4 1,1 214,1 214,137.8" filter="url(#ciq-hu-shadow)"/>
		<path class="ciq-hu-stroke" fill="#398DFF" d="M213,2v133.6l-13.7-11.8l-0.6-0.5H198H2V2H213 M215,0H0v125.4h198l17,14.6V0L215,0z"/>
	</svg>
	<div>
		<cq-hu-col1>
			<cq-hu-date></cq-hu-date>
			<cq-hu-price></cq-hu-price>
			<cq-volume-grouping>
				<div>Volume</div>
				<div><cq-volume-visual></cq-volume-visual></div>
				<div><cq-hu-volume></cq-hu-volume><cq-volume-rollup></cq-volume-rollup></div>
			</cq-volume-grouping>
		</cq-hu-col1>
		<cq-hu-col2>
			<div>Open</div><cq-hu-open></cq-hu-open>
			<div>Close</div><cq-hu-close></cq-hu-close>
			<div>High</div><cq-hu-high></cq-hu-high>
			<div>Low</div><cq-hu-low></cq-hu-low>
		</cq-hu-col2>
	</div>

</cq-hu-dynamic>

<div class="ciq-footer">
	<cq-share-button>
		<div stxtap="tap();">Share</div>
	</cq-share-button>
	<!--<div class="ciq-btn ciq-primary">Share!</div>-->
	<cq-show-range>
		<div stxtap="set(1,'today');">1D</div>
		<div stxtap="set(5,'day',30,2,'minute');">5D</div>
		<div stxtap="set(1,'month',30,8,'minute');">1M</div>
		<div class="hide-sm" stxtap="set(3,'month');">3M</div>
		<div class="hide-sm" stxtap="set(6,'month');">6M</div>
		<div class="hide-sm" stxtap="set(1,'YTD');">YTD</div>
		<div stxtap="set(1,'year');">1Y</div>
		<div class="hide-sm" stxtap="set(5,'year',1,1,'week');">5Y</div>
		<div class="hide-sm" stxtap="set(1,'all');">All</div>
	</cq-show-range>
</div>

<!-- End Footer -->

<cq-dialog>
    <cq-view-dialog>
	    <h4>Save View</h4>
	    <div stxtap="close()" class="ciq-icon ciq-close"></div>
	    <div style="text-align:center;margin-top:10px;">
		    <i>Enter name of view:</i>
		    <p>
		    	<input spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" maxlength="40" placeholder="Name"><br>
		    </p>
		    <span class="ciq-btn" stxtap="save()">Save</span>
		</div>
	</cq-view-dialog>
</cq-dialog>

<cq-dialog>
	<cq-aggregation-dialog>
		<h4 class="title"></h4>
		<div stxtap="hide()" class="ciq-icon ciq-close"></div>
		<div style="text-align:center;margin-top:10px;">
			<div class="ciqkagi">
				<i>Enter value and hit "Enter"</i>
				<p>
				<input name="kagi" stxtap="Layout.setAggregationEdit('kagi')">
			</div>
			<div class="ciqrenko">
				<i>Enter value and hit "Enter"</i>
				<p>
				<input name="renko" stxtap="Layout.setAggregationEdit('renko')">
			</div>
			<div class="ciqlinebreak">
				<i>Enter value and hit "Enter"</i>
				<p>
				<input name="priceLines" stxtap="Layout.setAggregationEdit('priceLines')">
			</div>
			<div class="ciqrangebars">
				<i>Enter value and hit "Enter"</i>
				<p>
				<input name="range" stxtap="Layout.setAggregationEdit('rangebars')">
			</div>
			<div class="ciqpandf">
				<i>Enter box size and hit "Enter"</i>
				<p>
				<input name="box" stxtap="Layout.setAggregationEdit('pandf.box')">
				<p>
				<i>Enter reversal and hit "Enter"</i>
				<p>
				<input name="reversal" stxtap="Layout.setAggregationEdit('pandf.reversal')">
			</div>
			<p>or
			<p>
			<div class="ciq-btn" stxtap="Layout.setAggregationEdit('auto')">Auto Select</div>
		</div>
	</cq-aggregation-dialog>
</cq-dialog>


<cq-dialog>
	<cq-study-context>
		<div stxtap="StudyEdit.edit()">Edit Settings...</div>
		<div stxtap="StudyEdit.remove()">Delete Study</div>
	</cq-study-context>
</cq-dialog>

<cq-dialog>
	<cq-fib-settings-dialog>
		<h4 class="title">Settings</h4>
		<cq-scroll cq-no-maximize>
			<cq-fibonacci-settings>
				<template cq-fibonacci-setting>
					<cq-fibonacci-setting>
						<div class="ciq-heading"></div>
						<div class="stx-data">
							<input type="checkbox">
						</div>
					</cq-fibonacci-setting>
				</template>
			</cq-fibonacci-settings>
			<div cq-custom-fibonacci-setting>
				<input class="ciq-heading" type="text">%
				<div class="ciq-btn stx-data" stxtap="add()">Add</div>
			</div>
		</cq-scroll>
		<div class="ciq-dialog-cntrls">
			<div class="ciq-btn" stxtap="close()">Done</div>
		</div>
	</cq-fib-settings-dialog>
</cq-dialog>

<cq-dialog>
	<cq-study-dialog>  <!-- add cq-study-axis cq-study-panel tags to this component to enable that functionality -->
		<h4 class="title">Study</h4>
		<cq-scroll cq-no-maximize>
			<cq-study-inputs>
				<template cq-study-input>
					<cq-study-input>
						<div class="ciq-heading"></div>
						<div class="stx-data">
							<template cq-menu>
								<cq-menu class="ciq-select">
									<cq-selected></cq-selected>
									<cq-menu-dropdown cq-lift></cq-menu-dropdown>
								</cq-menu>
							</template>
						</div>
					</cq-study-input>
					<hr>
				</template>
			</cq-study-inputs>
			<cq-study-outputs>
				<template cq-study-output>
					<cq-study-output>
						<div class="ciq-heading"></div>
						<cq-swatch cq-overrides="auto"></cq-swatch>
					</cq-study-output>
					<hr>
				</template>
			</cq-study-outputs>
			<cq-study-parameters>
				<template cq-study-parameters>
					<cq-study-parameter>
						<div class="ciq-heading"></div>
						<div class="stx-data"><cq-swatch cq-overrides="auto"></cq-swatch>
							<template cq-menu>
								<cq-menu class="ciq-select">
									<cq-selected></cq-selected>
									<cq-menu-dropdown cq-lift></cq-menu-dropdown>
								</cq-menu>
							</template>
						</div>
					</cq-study-parameter>
					<hr>
				</template>
			</cq-study-parameters>
		</cq-scroll>
		<div class="ciq-dialog-cntrls">
			<div class="ciq-btn" stxtap="close()">Done</div>
		</div>
	</cq-study-dialog>
</cq-dialog>

<cq-dialog>
	<cq-theme-dialog>
		<h4 class="title">Create Custom Theme</h4>
		<cq-close></cq-close>
		<cq-scroll cq-no-maximize>
			<cq-section>
				<cq-placeholder>Candle Color
					<cq-theme-piece cq-piece="cu"><cq-swatch cq-overrides="Hollow"></cq-swatch></cq-theme-piece>
					<cq-theme-piece cq-piece="cd"><cq-swatch cq-overrides="Hollow"></cq-swatch></cq-theme-piece>
				</cq-placeholder>
				<cq-placeholder>Candle Wick
					<cq-theme-piece cq-piece="wu"><cq-swatch></cq-swatch></cq-theme-piece>
					<cq-theme-piece cq-piece="wd"><cq-swatch></cq-swatch></cq-theme-piece>
				</cq-placeholder>
				<cq-placeholder>Candle Border
					<cq-theme-piece cq-piece="bu"><cq-swatch cq-overrides="No Border"></cq-swatch></cq-theme-piece>
					<cq-theme-piece cq-piece="bd"><cq-swatch cq-overrides="No Border"></cq-swatch></cq-theme-piece>
				</cq-placeholder>
				<cq-separator></cq-separator>
				<cq-placeholder>Line/Bar Chart
					<cq-theme-piece cq-piece="lc"><cq-swatch></cq-swatch></cq-theme-piece>
				</cq-placeholder>
				<cq-separator></cq-separator>
				<cq-placeholder>Mountain Color
					<cq-theme-piece cq-piece="mc"><cq-swatch></cq-swatch></cq-theme-piece>
				</cq-placeholder>
			</cq-section>
			<cq-section>
				<cq-placeholder>Background
					<cq-theme-piece cq-piece="bg"><cq-swatch></cq-swatch></cq-theme-piece>
				</cq-placeholder>
				<cq-placeholder>Grid Lines
					<cq-theme-piece cq-piece="gl"><cq-swatch></cq-swatch></cq-theme-piece>
				</cq-placeholder>
				<cq-placeholder>Date Dividers
					<cq-theme-piece cq-piece="dd"><cq-swatch></cq-swatch></cq-theme-piece>
				</cq-placeholder>
				<cq-placeholder>Axis Text<cq-theme-piece cq-piece="at"><cq-swatch></cq-swatch></cq-theme-piece>
				</cq-placeholder>
			</cq-section>
			<cq-action>
				<input><div stxtap="save()" class="ciq-btn">Save</div>
			</cq-action>
		</cq-scroll>
	</cq-theme-dialog>
</cq-dialog>

<cq-dialog>
	<cq-timezone-dialog>
		<h4 class="title">Choose Timezone</h4>
		<cq-close></cq-close>

		<p>To set your timezone use the location button below, or scroll through the following list...</p>
		<p id="currentUserTimeZone"></p>
    <div class="detect">
    <div class="ciq-btn" stxtap="removeTimezone()">Use My Current Location</div>
    </div>
    <div id="timezoneDialogWrapper" style="max-height:360px; overflow: auto;">
	        <ul>
	          <li id="timezoneTemplate" style="display:none;cursor:pointer;"></li>
	        </ul>
        </div>
    <div class="instruct">(Scroll for more options)</div>
	</cq-timezone-dialog>
</cq-dialog>

<cq-dialog>
	<cq-language-dialog>
		<h4 class="title">Choose language</h4>
		<cq-close></cq-close>
		<cq-languages>
			<template><div><cq-flag></cq-flag><cq-language-name></cq-language-name></div></template>
		</cq-languages>
	</cq-language-dialog>
</cq-dialog>

<cq-dialog>
	<cq-share-dialog>
		<div>
			<h4 class="title">Share Your Chart</h4>
			<cq-separator></cq-separator>
			<cq-share-create class="ciq-btn" stxtap="share()">Create Image</cq-share-create>
			<cq-share-generating style="display:none">Generating Image</cq-share-generating>
			<cq-share-uploading style="display:none">Uploading Image</cq-share-uploading>

			<div class="share-link-div"></div>

			<cq-separator></cq-separator>
			<div class="ciq-dialog-cntrls">
				<div stxtap="close()" class="ciq-btn">Done</div>
			</div>

		</div>
	</cq-share-dialog>
</cq-dialog>

<cq-side-panel></cq-side-panel>
</cq-context>
</div>
<!-- <script src="js/app.js"></script> -->

<script src="js/chartiq.js"></script>
<!--<script src="js/thirdparty/splines.js"></script>-->
<script src="js/quoteFeedSimulator.js"></script>
<script src="js/thirdparty/iscroll.js"></script>
<script src="js/plugin.js"></script>
<script src="js/translations.js"></script>
<script src="js/addOns.js"></script>
<script src="js/thirdparty/object-observe.js"></script>
<script src="js/thirdparty/webcomponents-lite.min.js"></script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
<script src='js/thirdparty/perfect-scrollbar.jquery.js'></script>
<script src="js/componentUI.js"></script>
<script src="js/thirdparty/html2canvas.js"></script>
<!-- <script src="plugins/tradingcentral/components.js"></script> -->
<script src="js/components.js"></script>

<script>

// Placeholder breakpoint classes

/**
 * Check the current width of the window and assign the appropriate css class
 * that will provide a better look and feel for your screen size.
 * Choices are small (break-sm), medium (break-md), large (break-lg)
 */
function checkWidth() {
	if ($(window).width() > 700) {
		$('.section-1-right').removeClass('break-md break-sm').addClass('break-lg');
		$('.icon-toggles').removeClass('sidenav active').addClass('ciq-toggles');
		stxx.layout.sidenav = 'sidenavOff';
		$('#symbol').attr("placeholder", "Enter Symbol");
		return;
	}
	if ($(window).width() <= 700 && $(window).width() > 584) {
		$('.section-1-right').removeClass('break-lg break-sm').addClass('break-md');
		$('.icon-toggles').removeClass('sidenav active').addClass('ciq-toggles');
		stxx.layout.sidenav = 'sidenavOff';
		$('#symbol').attr("placeholder", "Symbol");
		return;
	}
	if ($(window).width() <= 584) {
		$('.section-1-right').removeClass('break-md break-lg').addClass('break-sm');
		$('.icon-toggles').removeClass('ciq-toggles').addClass('sidenav');
		$('#symbol').attr("placeholder", "");
	}
}

function setHeight() {
	var windowHeight=$(window).height();
	var ciqHeight = $('.ciq-chart').height();

	if ($('.section-1-right').hasClass("toolbar-on")) {
		$('#chartContainer').height(ciqHeight - 45);
	} else {
		$('#chartContainer').height(ciqHeight);
	}
    // This little snippet will ensure that dialog boxes are never larger than the screen height
	$('#maxHeightCSS').remove();
	$('head').append('<style id="maxHeightCSS">cq-dialog { max-height: ' +  windowHeight + 'px }</style>');
}


$(".stx-markers cq-item.circle").stxtap(function(){
	$(".stx-markers .ciq-radio").removeClass("ciq-active");
	$(".stx-markers cq-item.circle .ciq-radio").addClass("ciq-active");
	showMarkers("circle");
});
$(".stx-markers cq-item.square").stxtap(function(){
	$(".stx-markers .ciq-radio").removeClass("ciq-active");
	$(".stx-markers cq-item.square .ciq-radio").addClass("ciq-active");
	showMarkers("square");
});
$(".stx-markers cq-item.callout").stxtap(function(){
	$(".stx-markers .ciq-radio").removeClass("ciq-active");
	$(".stx-markers cq-item.callout .ciq-radio").addClass("ciq-active");
	showMarkers("callout");
});
$(".stx-markers cq-item.abstract").stxtap(function(){
	$(".stx-markers .ciq-radio").removeClass("ciq-active");
	$(".stx-markers cq-item.abstract .ciq-radio").addClass("ciq-active");
	hideMarkers();
	var helicopter=$(".stx-marker.abstract").clone();
	helicopter.css({"z-index":"30","left":(0.4*stxx.chart.width).toString()+"px"});
	var marker=new CIQ.Marker({
		stx: stxx,
		xPositioner:"none",
		yPositioner:"above_candle",
		label: "helicopter",
		permanent: true,
		chartContainer: true,
		node: helicopter[0]
	});
	stxx.draw(); // call draw() when you're done adding markers. They will be positioned in batch.
});

$(".stx-markers cq-item.none").stxtap(function(){
	$(".stx-markers .ciq-radio").removeClass("ciq-active");
	$(".stx-markers cq-item.none .ciq-radio").addClass("ciq-active");
	hideMarkers();
});

var stxx=new CIQ.ChartEngine({container:$("#chartContainer")[0], preferences:{labels:false, currentPriceLine:true, whitespace:0}});

// Attach an automated quote feed to the chart to handle initial load, pagination and updates at preset intervals.
stxx.attachQuoteFeed(quoteFeedSimulator,{refreshInterval:1,bufferSize:200});

// Optionally set a market factory to the chart to make it market hours aware. Otherwise it will operate in 24x7 mode.
// This is required for the simulator, or if you intend to also enable Extended hours trading zones.
stxx.setMarketFactory(CIQ.Market.Symbology.factory);

// Extended hours trading zones -- Make sure this is instantiated before calling startUI as a timing issue with may occur
new CIQ.ExtendedHours({stx:stxx, filter:true});

// Floating tooltip on mousehover
// comment in the following line if you want a tooltip to display when the crosshair toggle is turned on
// This should be used as an *alternative* to the HeadsUP (HUD).
//new CIQ.Tooltip({stx:stxx, ohl:true, volume:true, series:true, studies:true});

// Inactivity timer
new CIQ.InactivityTimer({stx:stxx, minutes:30});

// Animation (using tension requires splines.js)
//new CIQ.Animation(stxx, {tension:0.3});

//TODO, encapsulate these in a helper object
function restoreLayout(stx, cb){
	var datum=CIQ.localStorage.getItem("myChartLayout");
	if(datum===null) return;
	function closure(){
		restoreDrawings(stx, stx.chart.symbol);
		if(cb) cb();
	}
	stx.importLayout(JSON.parse(datum), {managePeriodicity:true, cb: closure});
}

function saveLayout(obj){
	var s=JSON.stringify(obj.stx.exportLayout(true));
	CIQ.localStorageSetItem("myChartLayout", s);
}

function restoreDrawings(stx, symbol){
	var memory=CIQ.localStorage.getItem(symbol);
	if(memory!==null){
		var parsed=JSON.parse(memory);
		if(parsed){
			stx.importDrawings(parsed);
			stx.draw();
		}
	}
}

function saveDrawings(obj){
	var tmp=obj.stx.exportDrawings();
	if(tmp.length===0){
		CIQ.localStorage.removeItem(obj.symbol);
	}else{
		CIQ.localStorageSetItem(obj.symbol, JSON.stringify(tmp));
	}
}

function restorePreferences(){
	var pref=CIQ.localStorage.getItem("myChartPreferences");
	if (pref) stxx.importPreferences(JSON.parse(pref));
}

function savePreferences(obj){
	CIQ.localStorageSetItem("myChartPreferences",JSON.stringify(stxx.exportPreferences()));
}

function retoggleEvents(obj){
	var active=$(".stx-markers .ciq-radio.ciq-active");
	active.parent().triggerHandler("stxtap");
}

stxx.callbacks.layout=saveLayout;
stxx.callbacks.symbolChange=saveLayout;
stxx.callbacks.drawing=saveDrawings;
stxx.callbacks.newChart=retoggleEvents;
stxx.callbacks.preferences=savePreferences;

var UIContext;

function startUI(){
	UIContext=new CIQ.UI.Context(stxx, $("cq-context,[cq-context]"));
	var UILayout=new CIQ.UI.Layout(UIContext);
	var UIHeadsUpDynamic=new CIQ.UI.HeadsUp($("cq-hu-dynamic"), UIContext, {followMouse:true, autoStart: false});
	var UIHeadsUpStatic=new CIQ.UI.HeadsUp($("cq-hu-static"), UIContext, {autoStart: true});


	UIContext.changeSymbol=function(data){
		var stx=this.stx;
		if(this.loader) this.loader.show();
		data.symbol=data.symbol.toUpperCase(); // set a pretty display version


		// reset comparisons - remove this loop to transfer from symbol to symbol.
		for(var field in stx.chart.series) {
			// keep studies
			if (stxx.chart.series[field].parameters.bucket != "study" ) stx.removeSeries(field);
		}

		var self=this;
		stx.newChart(data, null, null, function(err){
			if(err){
				//TODO, symbol not found error
				if(self.loader) self.loader.hide();
				return;

			}
			// The user has changed the symbol, populate $("cq-chart-title")[0].previousClose with yesterday's closing price

			if(stx.tfc) stx.tfc.changeSymbol();   // Update trade from chart
			if(self.loader) self.loader.hide();
			restoreDrawings(stx, stx.chart.symbol);
		});
	};


	UIContext.setLookupDriver(new CIQ.UI.Lookup.Driver.ChartIQ());

	UIContext.UISymbolLookup=$(".ciq-search cq-lookup")[0];
	UIContext.UISymbolLookup.setCallback(function(context, data){
		context.changeSymbol(data);
	});

	var KeystrokeHub=new CIQ.UI.KeystrokeHub($(".section-1-right"), UIContext, {cb:CIQ.UI.KeystrokeHub.defaultHotKeys});

	var UIStudyEdit=new CIQ.UI.StudyEdit(null, UIContext);

	var UIStorage=new CIQ.NameValueStore();

	var UIThemes=$("cq-themes");
	UIThemes[0].initialize({
		builtInThemes: {"ciq-day":"Day","ciq-night":"Night"},
		defaultTheme: "ciq-night",
		nameValueStore: UIStorage
	});

	var sidePanel=$("cq-side-panel")[0];
	if(sidePanel) sidePanel.registerCallback(resizeScreen);

	$(".ciq-sidenav")[0].registerCallback(function (value) {
		var stx=this.context.stx, rightPx;
		var sidePanelWidth = sidePanel?sidePanel.nonAnimatedWidth():0;
		if (value === 'sidenavOn') {
			var chartHolderHeight = $('.stx-holder').height();
			$('.sidenav').height(chartHolderHeight);
			this.node.addClass("active");
			stx.layout.sidenav = "sidenavOn";
			$('.sidenav').addClass("active");
			rightPx=this.node.width()+sidePanelWidth;
		} else if (value === 'sidenavOff') {
			rightPx=sidePanelWidth;
			$('.sidenav').removeClass("active");
			this.node.removeClass("active");
			stx.layout.sidenav = "sidenavOff";
		}
		$("cq-side-panel").css("right", rightPx - sidePanelWidth +"px");
		$('.ciq-chart-area').css({'right': rightPx +'px'});
		$('cq-tradingcentral').css({'margin-right': rightPx + 15 + 'px'});
		if(stx.slider) stx.slider.display(stx.layout.rangeSlider);
	});

	$(".ciq-HU")[0].registerCallback(function(value){
		if(value==="static"){
			UIHeadsUpDynamic.end();
			UIHeadsUpStatic.begin();
			this.node.addClass("active");
		}else if(value==="dynamic"){
			if(CIQ.isMobile){
				// The dynamic headsUp doesn't make any sense on mobile devices so we skip that toggle
				// by manually setting the toggle to "static"
				this.set("static");
				UIHeadsUpDynamic.end();
				UIHeadsUpStatic.begin();
				this.node.addClass("active");
			}else{
				UIHeadsUpStatic.end();
				UIHeadsUpDynamic.begin();
				this.node.addClass("active");
			}
		}else{
			UIHeadsUpStatic.end();
			UIHeadsUpDynamic.end();
			this.node.removeClass("active");
		}
	});
	$(".ciq-draw")[0].registerCallback(function(value){
		if(value){
			this.node.addClass("active");
			$(".section-1-right").addClass("toolbar-on");
		}else{
			this.node.removeClass("active");
			$(".section-1-right").removeClass("toolbar-on");
		}
		setHeight();
		var stx=this.context.stx;
		stx.resizeChart();

		// a little code here to remember what the previous drawing tool was
		// and to re-enable it when the toolbar is reopened
		if(value){
			stx.changeVectorType(this.priorVectorType);
		}else{
			this.priorVectorType=stx.currentVectorParameters.vectorType;
			stx.changeVectorType("");
		}
	});

	if( $('.stx-trade')[0] ) {
		$('.stx-trade')[0].registerCallback(function(value) {
			var sidePanel=$("cq-side-panel")[0];
			if(value){
				sidePanel.open({selector:".stx-trade-panel",className:"active"});
				this.node.addClass("active");
				$(".stx-trade-panel").removeClass("closed");
				stxx.layout.sidenav = 'sidenavOff'; // in break-sm hide sidenav when turning on tfc side panel
			}else{
				sidePanel.close();
				this.node.removeClass("active");
				$(".stx-trade-panel").addClass("closed");
			}
		});
	}

	if( $('.stx-tradingcentral')[0] ) {
		$('.stx-tradingcentral')[0].registerCallback(function(value) {
			var tcElement = $('cq-tradingcentral')[0];
			if (value) {
				tcElement.removeAttribute('disabled');
			} else {
				tcElement.setAttribute('disabled', 'disabled');
			}
		});
	}

	$("cq-redo")[0].pairUp($("cq-undo"));

	$("cq-views").each(function(){
		this.initialize();
	});

	var params={
		excludedStudies: {
			"Directional": true,
			"Gopala":true,
			"vchart":true
		},
		alwaysDisplayDialog: {"ma":true},
		/*dialogBeforeAddingStudy: {"rsi": true} // here's how to always show a dialog before adding the study*/
	};

	$("cq-studies").each(function(){
		this.initialize(params);
	});

	if(UIContext.loader) UIContext.loader.show();
	restorePreferences();
	restoreLayout(stxx, function(){
		if(UIContext.loader) UIContext.loader.hide();
	});

	if(!stxx.chart.symbol){
		UIContext.UISymbolLookup.selectItem({symbol:"AAPL"}); // load an initial symbol
	}

	CIQ.UI.begin();

	//CIQ.I18N.setLanguage(stxx, "zh");		// Optionally set a language for the UI, after it has been initialized, and translate.
}

function hideMarkers(){
	CIQ.Marker.removeByLabel(stxx, "circle");
	CIQ.Marker.removeByLabel(stxx, "square");
	CIQ.Marker.removeByLabel(stxx, "callout");
	CIQ.Marker.removeByLabel(stxx, "helicopter");
}

function showMarkers(standardType){
	// Remove any existing markers
	hideMarkers();
	var l=stxx.masterData.length;
	// An example of a data array to drive the marker creation
	var data=[
		{x:stxx.masterData[l-5].DT, type:standardType, category:"news", headline:"This is a Marker for a News Item"},
		{x:stxx.masterData[l-15].DT, type:standardType, category:"earningsUp", headline:"This is a Marker for Earnings (+)"},
		{x:stxx.masterData[l-25].DT, type:standardType, category:"earningsDown", headline:"This is a Marker for Earnings (-)"},
		{x:stxx.masterData[l-35].DT, type:standardType, category:"dividend", headline:"This is a Marker for Dividends"},
		{x:stxx.masterData[l-45].DT, type:standardType, category:"filing", headline:"This is a Marker for a Filing"},
		{x:stxx.masterData[l-55].DT, type:standardType, category:"split", headline:"This is a Marker for a Split"}
	];
	var story="Like all ChartIQ markers, the object itself is managed by the chart, so when you scroll the chart the object moves with you. It is also destroyed automatically for you when the symbol is changed.";

	// Loop through the data and create markers
	for(var i=0;i<data.length;i++){
		var datum=data[i];
		datum.story=story;
		var params={
			stx:stxx,
			label:standardType,
			xPositioner:"date",
			x: datum.x,
			//chartContainer: true, // Allow markers to float out of chart. Set css .stx-marker{ z-index:20}
			node: new CIQ.Marker.Simple(datum)
		};

		var marker=new CIQ.Marker(params);
	}
	stxx.draw();
}

function resizeScreen(){
	if(!UIContext) return;
	checkWidth();
	setHeight();
	var sidePanel=$("cq-side-panel")[0];
	var sideNav = $('.sidenav');
	var sideNavWidth = sideNav.hasClass("active") ? sideNav.width() : 0;
	if(sidePanel){
		$('.ciq-chart-area').css({'right': sidePanel.nonAnimatedWidth() + sideNavWidth +'px'});
		$('cq-tradingcentral').css({'margin-right': sidePanel.nonAnimatedWidth() + 15 + 'px'});
	} else {
		$('.ciq-chart-area').css({'right': sideNavWidth +'px'});
	}
	stxx.resizeChart();
	if(stxx.slider) stxx.slider.display(stxx.layout.rangeSlider);
}

//Range Slider; needs to be created before startUI() is called for custom themes to apply
new CIQ.RangeSlider({stx:stxx});

var webComponentsSupported = ('registerElement' in document &&
		  'import' in document.createElement('link') &&
		  'content' in document.createElement('template'));

if(webComponentsSupported){
	startUI();
	resizeScreen();
}else{
	window.addEventListener('WebComponentsReady', function(e) {
		startUI();
		resizeScreen();
	});
}
if(typeof Promise === 'undefined') CIQ.loadScript('js/thirdparty/promise.min.js'); // Necessary for IE and MSFT Edge if you are using sharing (because html2canvas uses promises)
$(window).resize(resizeScreen);

</script>
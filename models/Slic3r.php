<?php
/**
*	Slic3r execution class for PHP
*	Creation Date: February 2014
*	@author Albert Chau
*	@version 1.0
*/		
class Slic3r {
	/**
	* Command string to execute slic3r.pl.
	* @var string
	*/
	private $Command;
			
	/**
	* The INI file name to load for Slic3r options.
	* @var string
	*/
	private $ConfigFileName;
			
	/**
	* The full path name of the input STL file.
	* @var string
	*/
	private $InputFilename;
			
	/**
	* The full path name of the output STL file.
	* @var string
	*/
	private $OutputFilename;
			
	/**
	* Output file name format; all config options enclosed in brackets will be replaced by their values, as well as [input_filename_base] and [input_filename] (default: [input_filename_base].gcode)
	* @var string
	*/
	private $OutputFilenameFormat;
			
	/**
	* Generated G-code will be processed with the supplied script; call this more than once to process through multiple scripts.
	* @var boolean
	*/
	private $PostProcess;
			
	/**
	* Export a SVG file containing slices instead of G-code.
	* @var boolean
	*/
	private $ExportSVG;
			
	/**
	* If multiple files are supplied, they will be composed into a single print rather than processed individually.
	* @var boolean
	*/
	private $Merge;
			
	/**
	* Diameter of nozzle in mm (default: 0.5)
	* @var float
	*/
	private $NozzleDiameter;
			
	/**
	* Coordinates in mm of the point to center the print around (default: 100,100)
	* @var int
	*/
	private $PrintCenter;
			
	/**
	* Additional height in mm to add to vertical coordinates (+/-, default: 0)
	* @var float
	*/
	private $ZOffset;
			
	/**
	* The type of G-code to generate (reprap/teacup/makerware/sailfish/mach3/no-extrusion, default: reprap)
	* @var string
	*/
	private $GCodeFlavor;
			
	/**
	* Enable this to get relative E values (default: no)
	* @var boolean
	*/
	private $UseRelativeEDistance;
			
	/**
	* Enable firmware-controlled retraction using G10/G11 (default: no)
	* @var boolean
	*/
	private $UseFirmwareRetraction;
			
	/**
	* Use G2/G3 commands for native arcs (experimental, not supported by all firmwares)
	* @var boolean
	*/
	private $GCodeArcs;
			
	/**
	* Use G0 commands for retraction (experimental, not supported by all firmwares)
	* @var boolean
	*/
	private $G0;
			
	/**
	* Make G-code verbose by adding comments (default: no)
	* @var boolean
	*/
	private $GCodeComments;
			
	/**
	* Limit the frequency of moves on X and Y axes (Hz, set zero to disable; default: 0)
	* @var float
	*/
	private $VibrationLimit;
			
	/**
	* Diameter in mm of your raw filament (default: 3)
	* @var float
	*/
	private $FilamentDiameter;
			
	/**
	* Change this to alter the amount of plastic extruded. There should be very little need to change this value, which is only useful to compensate for filament packing (default: 1)
	* @var int
	*/
	private $ExtrusionMultiplier;
			
	/**
	* Extrusion temperature in degree Celsius, set 0 to disable (default: 200)
	* @var int
	*/
	private $Temperature;
			
	/**
	* Extrusion temperature for the first layer, in degree Celsius, set 0 to disable (default: same as --temperature)
	* @var int
	*/
	private $FirstLayerTemperature;
			
	/**
	* Heated bed temperature in degree Celsius, set 0 to disable (default: 0)
	* @var int
	*/
	private $BedTemperature;
			
	/**
	* Heated bed temperature for the first layer, in degree Celsius, set 0 to disable (default: same as --bed-temperature)
	* @var int
	*/
	private $FirstLayerBedTemperature;
			
	/**
	* Speed of non-print moves in mm/s (default: 130)
	* @var int
	*/
	private $TravelSpeed;
			
	/**
	* Speed of print moves for perimeters in mm/s (default: 30)
	* @var int
	*/
	private $PerimeterSpeed;
			
	/**
	* Speed of print moves for small perimeters in mm/s or % over perimeter speed (default: 30)
	* @var int
	*/
	private $SmallPerimeterSpeed;
			
	/**
	* Speed of print moves for the external perimeter in mm/s or % over perimeter speed (default: 70%)
	* @var int
	*/
	private $ExternalPerimeterSpeed;
			
	/**
	* Speed of print moves in mm/s (default: 60)
	* @var int
	*/
	private $InfillSpeed;
			
	/**
	* Speed of print moves for solid surfaces in mm/s or % over infill speed (default: 60)
	* @var int
	*/
	private $SolidInfillSpeed;
			
	/**
	* Speed of print moves for top surfaces in mm/s or % over solid infill speed (default: 50)
	* @var int
	*/
	private $TopSolidInfillSpeed;
			
	/**
	* Speed of support material print moves in mm/s (default: 60)
	* @var int
	*/
	private $SupportMaterialSpeed;
			
	/**
	* Speed of bridge print moves in mm/s (default: 60)
	* @var int
	*/
	private $BridgeSpeed;
			
	/**
	* Speed of gap fill print moves in mm/s (default: 20)
	* @var int
	*/
	private $GapFillSpeed;
			
	/**
	* Speed of print moves for bottom layer, expressed either as an absolute value or as a percentage over normal speeds (default: 30%)
	* @var int
	*/
	private $FirstLayerSpeed;
			
	/**
	* Overrides firmware's default acceleration for perimeters. (mm/s^2, set zero to disable; default: 0)
	* @var int
	*/
	private $PerimeterAcceleration;
			
	/**
	* Overrides firmware's default acceleration for infill. (mm/s^2, set zero to disable; default: 0)
	* @var int
	*/
	private $InfillAcceleration;
			
	/**
	* Overrides firmware's default acceleration for bridges. (mm/s^2, set zero to disable; default: 0)
	* @var int
	*/
	private $BridgeAcceleration;
			
	/**
	* Overrides firmware's default acceleration for first layer. (mm/s^2, set zero to disable; default: 0)
	* @var int
	*/
	private $FirstLayerAcceleration;
			
	/**
	* Acceleration will be reset to this value after the specific settings above have been applied. (mm/s^2, set zero to disable; default: 130)
	* @var int
	*/
	private $DefaultAcceleration;
			
	/**
	* Layer height in mm (default: 0.4)
	* @var float
	*/
	private $LayerHeight;
			
	/**
	* Layer height for first layer (mm or %, default: 0.35)
	* @var float
	*/
	private $FirstLayerHeight;
			
	/**
	* Infill every N layers (default: 1)
	* @var int
	*/
	private $InfillEveryLayer;
			
	/**
	* Force a solid layer every N layers (default: 0)
	* @var int
	*/
	private $SolidInfillEveryLayers;
			
	/**
	* Number of perimeters/horizontal skins (range: 0+, default: 3)
	* @var int
	*/
	private $Perimeters;
			
	/**
	* Number of solid layers to do for top surfaces (range: 0+, default: 3)
	* @var int
	*/
	private $TopSolidLayers;
			
	/**
	* Number of solid layers to do for bottom surfaces (range: 0+, default: 3)
	* @var int
	*/
	private $BottomSolidLayers;
			
	/**
	* Shortcut for setting the two options above at once
	* @var boolean
	*/
	private $SolidLayers;
			
	/**
	* Infill density (range: 0-1, default: 0.4)
	* @var float
	*/
	private $FillDensity;
			
	/**
	* Infill angle in degrees (range: 0-90, default: 45)
	* @var int
	*/
	private $FillAngle;
			
	/**
	* Pattern to use to fill non-solid layers (default: honeycomb)
	* @var string
	*/
	private $FillPattern;
			
	/**
	* Pattern to use to fill solid layers (default: rectilinear)
	* @var string
	*/
	private $SolidFillPattern;
			
	/**
	* Load initial G-code from the supplied file. This will overwrite the default command (home all axes [G28]).
	* @var boolean
	*/
	private $StartGCode;
			
	/**
	* Load final G-code from the supplied file. This will overwrite the default commands (turn off temperature [M104 S0], home X axis [G28 X], disable motors [M84]).
	* @var boolean
	*/
	private $EndGCode;
			
	/**
	* Load layer-change G-code from the supplied file (default: nothing).
	* @var boolean
	*/
	private $LayerGCode;
			
	/**
	* Load tool-change G-code from the supplied file (default: nothing).
	* @var boolean
	*/
	private $ToolChangeGCode;
			
	/**
	* Randomize starting point across layers (default: yes)
	* @var boolean
	*/
	private $RadomizeStart;
			
	/**
	* Reverse perimeter order. (default: no)
	* @var boolean
	*/
	private $ExternalPerimeterFirst;
			
	/**
	* Experimental option to raise Z gradually when printing single-walled vases (default: no)
	* @var boolean
	*/
	private $SpiralVase;
			
	/**
	* Disable retraction when travelling between infill paths inside the same island. (default: no)
	* @var boolean
	*/
	private $OnlyRetractWhenCrossingPerimeters;
			
	/**
	* Force solid infill when a region has a smaller area than this threshold (mm^2, default: 70)
	* @var int
	*/
	private $SolidInfillBelowArea;
			
	/**
	* Only infill under ceilings (default: no)
	* @var boolean
	*/
	private $InfillOnlyWhereNeeded;
			
	/**
	* Make infill before perimeters (default: no)
	* @var boolean
	*/
	private $InfillFirst;
			
	/**
	* Add more perimeters when needed (default: yes)
	* @var boolean
	*/
	private $ExtraPerimeters;
			
	/**
	* Optimize travel moves so that no perimeters are crossed (default: no)
	* @var boolean
	*/
	private $AvoidCrossingPerimeters;
			
	/**
	* Try to start perimeters at concave points if any (default: no)
	* @var boolean
	*/
	private $StartPerimetersAtConcavePoints;
			
	/**
	* Try to start perimeters at non-overhang points if any (default: no)
	* @var boolean
	*/
	private $StartPerimetersAtNonOverhang;
			
	/**
	* Detect single-width walls (default: yes)
	* @var boolean
	*/
	private $ThinWalls;
			
	/**
	* Experimental option to use bridge flow, speed and fan for overhangs (default: yes)
	* @var boolean
	*/
	private $OverHangs;
			
	/**
	* Generate support material for overhangs
	* @var boolean
	*/
	private $SupportMaterial;
			
	/**
	* Overhang threshold angle (range: 0-90, set 0 for automatic detection, default: 0)
	* @var int
	*/
	private $SupportMaterialThreshold;
			
	/**
	* Pattern to use for support material (default: honeycomb)
	* @var string
	*/
	private $SupportMaterialPattern;
			
	/**
	* Spacing between pattern lines (mm, default: 2.5)
	* @var float
	*/
	private $SupportMaterialSpacing;
			
	/**
	* Support material angle in degrees (range: 0-90, default: 0)
	* @var int
	*/
	private $SupportMaterialAngle;
			
	/**
	* Number of perpendicular layers between support material and object (0+, default: 3)
	* @var int
	*/
	private $SupportMaterialInterfaceLayers;
			
	/**
	* Spacing between interface pattern lines (mm, set 0 to get a solid layer, default: 0)
	* @var int
	*/
	private $SupportMaterialInterfaceSpacing;
			
	/**
	* Number of layers to raise the printed objects by (range: 0+, default: 0)
	* @var int
	*/
	private $RaftLayers;
			
	/**
	* Enforce support material on the specified number of layers from bottom, regardless of --support-material and threshold (0+, default: 0)
	* @var int
	*/
	private $SupportMaterialEnforceLayers;
			
	/**
	* Length of retraction in mm when pausing extrusion (default: 1)
	* @var int
	*/
	private $RetractLength;
			
	/**
	* Speed for retraction in mm/s (default: 30)
	* @var int
	*/
	private $RetractSpeed;
			
	/**
	* Additional amount of filament in mm to push after compensating retraction (default: 0)
	* @var int
	*/
	private $RetractRestartExtra;
			
	/**
	* Only retract before travel moves of this length in mm (default: 2)
	* @var int
	*/
	private $RetractBeforeTravel;
			
	/**
	* Lift Z by the given distance in mm when retracting (default: 0)
	* @var int
	*/
	private $RetractLift;
			
	/**
	* Enforce a retraction before each Z move (default: yes)
	* @var boolean
	*/
	private $RetractLayerChange;
			
	/**
	* Wipe the nozzle while doing a retraction (default: no)
	* @var boolean
	*/
	private $Wipe;
			
	/**
	* Length of retraction in mm when disabling tool (default: 1)
	* @var int
	*/
	private $RetractLengthToolChange;
			
	/**
	* Additional amount of filament in mm to push after switching tool (default: 0)
	* @var int
	*/
	private $RetractRestartExtraToolChange;
			
	/**
	* Enable fan and cooling control
	* @var boolean
	*/
	private $Cooling;
			
	/**
	* Minimum fan speed (default: 35%)
	* @var int
	*/
	private $MinFanSpeed;
			
	/**
	* Maximum fan speed (default: 100%)
	* @var int
	*/
	private $MaxFanSpeed;
			
	/**
	* Fan speed to use when bridging (default: 100%)
	* @var int
	*/
	private $BridgeFanSpeed;
			
	/**
	* Enable fan if layer print time is below this approximate number  of seconds (default: 60)
	* @var int
	*/
	private $FanBelowLayerTime;
			
	/**
	* Slow down if layer print time is below this approximate number of seconds (default: 30)
	* @var int
	*/
	private $SlowdownBelowLayerTime;
			
	/**
	* Minimum print speed (mm/s, default: 10)
	* @var int
	*/
	private $MinPrintSpeed;
			
	/**
	* Disable fan for the first N layers (default: 1)
	* @var int
	*/
	private $DisableFanFirstLayers;
			
	/**
	* Keep fan always on at min fan speed, even for layers that don't need cooling
	* @var boolean
	*/
	private $FanAlwaysOn;
			
	/**
	* Number of skirts to draw (0+, default: 1)
	* @var int
	*/
	private $Skirts;
			
	/**
	* Distance in mm between innermost skirt and object (default: 6)
	* @var int
	*/
	private $SkirtDistance;
			
	/**
	* Height of skirts to draw (expressed in layers, 0+, default: 1)
	* @var int
	*/
	private $SkirtHeight;
			
	/**
	* Generate no less than the number of loops required to consume this length of filament on the first layer, for each extruder (mm, 0+, default: 0)
	* @var int
	*/
	private $MinSkirtLength;
			
	/**
	* Width of the brim that will get added to each object to help adhesion (mm, default: 0)
	* @var int
	*/
	private $BrimWidth;
			
	/**
	* Factor for scaling input object (default: 1)
	* @var int
	*/
	private $Scale;
			
	/**
	* Rotation angle in degrees (0-360, default: 0)
	* @var int
	*/
	private $Rotate;
			
	/**
	* Number of items with auto-arrange (1+, default: 1)
	* @var int
	*/
	private $Duplicate;
			
	/**
	* Bed size, only used for auto-arrange (mm, default: 200,200)
	* @var string
	*/
	private $BedSize;
			
	/**
	* Number of items with grid arrangement (default: 1,1)
	* @var string
	*/
	private $DuplicateGrid;
			
	/**
	* Distance in mm between copies (default: 6)
	* @var int
	*/
	private $DuplicateDistance;
			
	/**
	* When printing multiple objects and/or copies, complete each one before starting the next one; watch out for extruder collisions (default: no)
	* @var boolean
	*/
	private $CompleteObjects;
			
	/**
	* Radius in mm above which extruder won't collide with anything (default: 20)
	* @var int
	*/
	private $ExtrudeClearanceRadius;
			
	/**
	* Maximum vertical extruder depth; i.e. vertical distance from extruder tip and carriage bottom (default: 20)
	* @var int
	*/
	private $ExtrudeClearanceHeight;
			
	/**
	* Notes to be added as comments to the output file
	* @var string
	*/
	private $Notes;
			
	/**
	* Minimum detail resolution (mm, set zero for full resolution, default: 0)
	* @var int
	*/
	private $Resolution;
			
	/**
	* Set extrusion width manually; it accepts either an absolute value in mm (like 0.65) or a percentage over layer height (like 200%)
	* @var string
	*/
	private $ExtrusionWidth;
			
	/**
	* Set a different extrusion width for first layer
	* @var string
	*/
	private $FirstLayerExtrusionWidth;
			
	/**
	* Set a different extrusion width for perimeters
	* @var string
	*/
	private $PerimeterExtrusionWidth;
			
	/**
	* Set a different extrusion width for infill
	* @var string
	*/
	private $InfillExtrusionWidth;
			
	/**
	* Set a different extrusion width for solid infill
	* @var string
	*/
	private $SolidInfillExtrusionWidth;
			
	/**
	* Set a different extrusion width for top infill
	* @var string
	*/
	private $TopInfillExtrusionWidth;
			
	/**
	* Set a different extrusion width for support material
	* @var string
	*/
	private $SupportMaterialExtrusionWidth;
			
	/**
	* Multiplier for extrusion when bridging (&gt; 0, default: 1)
	* @var int
	*/
	private $BridgeFlowRatio;
			
	/**
	* Offset of each extruder, if firmware doesn't handle the displacement (can be specified multiple times, default: 0x0)
	* @var string
	*/
	private $ExtruderOffset;
			
	/**
	* Extruder to use for perimeters (1+, default: 1)
	* @var int
	*/
	private $PerimeterExtruder;
			
	/**
	* Extruder to use for infill (1+, default: 1)
	* @var int
	*/
	private $InfillExtruder;
			
	/**
	* Extruder to use for support material (1+, default: 1)
	* @var int
	*/
	private $SupportMaterialExtruder;
			
	/**
	* Extruder to use for support material interface (1+, default: 1)
	* @var int
	*/
	private $SupportMaterialInterfaceExtruder;
			
	/**
	* Drop temperature and park extruders outside a full skirt for automatic wiping (default: no)
	* @var boolean
	*/
	private $OozePrevention;
			
	/**
	* Temperature difference to be applied when an extruder is not active and --ooze-prevention is enabled (default: -5)
	* @var int
	*/
	private $StandbyTemperatureDelta;
			
	/**
	* Axis of the extrusion (Undocumented)
	* @var string
	*/
	private $ExtrusionAxis;
			
	/**
	* Number of Slic3r threads to run (Undocumented)
	* @var int
	*/
	private $Threads;
			

	/**
	* Command string to execute slic3r.pl.
	* @return string
	*/
	public function getCommand() {
		return($this->Command);
	}
	/**
	* Command string to execute slic3r.pl.
	* @param string $value
	*/
	public function setCommand($value) {
		$this->Command = $value;
	}
	
	/**
	* The INI file name to load for Slic3r options.
	* @return string
	*/
	public function getConfigFileName() {
		return($this->ConfigFileName);
	}
	/**
	* The INI file name to load for Slic3r options.
	* @param string $value
	*/
	public function setConfigFileName($value) {
		$this->ConfigFileName = $value;
	}
	
	/**
	* The full path name of the input STL file.
	* @return string
	*/
	public function getInputFilename() {
		return($this->InputFilename);
	}
	/**
	* The full path name of the input STL file.
	* @param string $value
	*/
	public function setInputFilename($value) {
		$this->InputFilename = $value;
	}
	
	/**
	* The full path name of the output STL file.
	* @return string
	*/
	public function getOutputFilename() {
		return($this->OutputFilename);
	}
	/**
	* The full path name of the output STL file.
	* @param string $value
	*/
	public function setOutputFilename($value) {
		$this->OutputFilename = $value;
	}
	
	/**
	* Output file name format; all config options enclosed in brackets will be replaced by their values, as well as [input_filename_base] and [input_filename] (default: [input_filename_base].gcode)
	* @return string
	*/
	public function getOutputFilenameFormat() {
		return($this->OutputFilenameFormat);
	}
	/**
	* Output file name format; all config options enclosed in brackets will be replaced by their values, as well as [input_filename_base] and [input_filename] (default: [input_filename_base].gcode)
	* @param string $value
	*/
	public function setOutputFilenameFormat($value) {
		$this->OutputFilenameFormat = $value;
	}
	
	/**
	* Generated G-code will be processed with the supplied script; call this more than once to process through multiple scripts.
	* @return boolean
	*/
	public function getPostProcess() {
		return($this->PostProcess);
	}
	/**
	* Generated G-code will be processed with the supplied script; call this more than once to process through multiple scripts.
	* @param boolean $value
	*/
	public function setPostProcess($value) {
		$this->PostProcess = $value;
	}
	
	/**
	* Export a SVG file containing slices instead of G-code.
	* @return boolean
	*/
	public function getExportSVG() {
		return($this->ExportSVG);
	}
	/**
	* Export a SVG file containing slices instead of G-code.
	* @param boolean $value
	*/
	public function setExportSVG($value) {
		$this->ExportSVG = $value;
	}
	
	/**
	* If multiple files are supplied, they will be composed into a single print rather than processed individually.
	* @return boolean
	*/
	public function getMerge() {
		return($this->Merge);
	}
	/**
	* If multiple files are supplied, they will be composed into a single print rather than processed individually.
	* @param boolean $value
	*/
	public function setMerge($value) {
		$this->Merge = $value;
	}
	
	/**
	* Diameter of nozzle in mm (default: 0.5)
	* @return float
	*/
	public function getNozzleDiameter() {
		return($this->NozzleDiameter);
	}
	/**
	* Diameter of nozzle in mm (default: 0.5)
	* @param float $value
	*/
	public function setNozzleDiameter($value) {
		$this->NozzleDiameter = $value;
	}
	
	/**
	* Coordinates in mm of the point to center the print around (default: 100,100)
	* @return int
	*/
	public function getPrintCenter() {
		return($this->PrintCenter);
	}
	/**
	* Coordinates in mm of the point to center the print around (default: 100,100)
	* @param int $value
	*/
	public function setPrintCenter($value) {
		$this->PrintCenter = $value;
	}
	
	/**
	* Additional height in mm to add to vertical coordinates (+/-, default: 0)
	* @return float
	*/
	public function getZOffset() {
		return($this->ZOffset);
	}
	/**
	* Additional height in mm to add to vertical coordinates (+/-, default: 0)
	* @param float $value
	*/
	public function setZOffset($value) {
		$this->ZOffset = $value;
	}
	
	/**
	* The type of G-code to generate (reprap/teacup/makerware/sailfish/mach3/no-extrusion, default: reprap)
	* @return string
	*/
	public function getGCodeFlavor() {
		return($this->GCodeFlavor);
	}
	/**
	* The type of G-code to generate (reprap/teacup/makerware/sailfish/mach3/no-extrusion, default: reprap)
	* @param string $value
	*/
	public function setGCodeFlavor($value) {
		$this->GCodeFlavor = $value;
	}
	
	/**
	* Enable this to get relative E values (default: no)
	* @return boolean
	*/
	public function getUseRelativeEDistance() {
		return($this->UseRelativeEDistance);
	}
	/**
	* Enable this to get relative E values (default: no)
	* @param boolean $value
	*/
	public function setUseRelativeEDistance($value) {
		$this->UseRelativeEDistance = $value;
	}
	
	/**
	* Enable firmware-controlled retraction using G10/G11 (default: no)
	* @return boolean
	*/
	public function getUseFirmwareRetraction() {
		return($this->UseFirmwareRetraction);
	}
	/**
	* Enable firmware-controlled retraction using G10/G11 (default: no)
	* @param boolean $value
	*/
	public function setUseFirmwareRetraction($value) {
		$this->UseFirmwareRetraction = $value;
	}
	
	/**
	* Use G2/G3 commands for native arcs (experimental, not supported by all firmwares)
	* @return boolean
	*/
	public function getGCodeArcs() {
		return($this->GCodeArcs);
	}
	/**
	* Use G2/G3 commands for native arcs (experimental, not supported by all firmwares)
	* @param boolean $value
	*/
	public function setGCodeArcs($value) {
		$this->GCodeArcs = $value;
	}
	
	/**
	* Use G0 commands for retraction (experimental, not supported by all firmwares)
	* @return boolean
	*/
	public function getG0() {
		return($this->G0);
	}
	/**
	* Use G0 commands for retraction (experimental, not supported by all firmwares)
	* @param boolean $value
	*/
	public function setG0($value) {
		$this->G0 = $value;
	}
	
	/**
	* Make G-code verbose by adding comments (default: no)
	* @return boolean
	*/
	public function getGCodeComments() {
		return($this->GCodeComments);
	}
	/**
	* Make G-code verbose by adding comments (default: no)
	* @param boolean $value
	*/
	public function setGCodeComments($value) {
		$this->GCodeComments = $value;
	}
	
	/**
	* Limit the frequency of moves on X and Y axes (Hz, set zero to disable; default: 0)
	* @return float
	*/
	public function getVibrationLimit() {
		return($this->VibrationLimit);
	}
	/**
	* Limit the frequency of moves on X and Y axes (Hz, set zero to disable; default: 0)
	* @param float $value
	*/
	public function setVibrationLimit($value) {
		$this->VibrationLimit = $value;
	}
	
	/**
	* Diameter in mm of your raw filament (default: 3)
	* @return float
	*/
	public function getFilamentDiameter() {
		return($this->FilamentDiameter);
	}
	/**
	* Diameter in mm of your raw filament (default: 3)
	* @param float $value
	*/
	public function setFilamentDiameter($value) {
		$this->FilamentDiameter = $value;
	}
	
	/**
	* Change this to alter the amount of plastic extruded. There should be very little need to change this value, which is only useful to compensate for filament packing (default: 1)
	* @return int
	*/
	public function getExtrusionMultiplier() {
		return($this->ExtrusionMultiplier);
	}
	/**
	* Change this to alter the amount of plastic extruded. There should be very little need to change this value, which is only useful to compensate for filament packing (default: 1)
	* @param int $value
	*/
	public function setExtrusionMultiplier($value) {
		$this->ExtrusionMultiplier = $value;
	}
	
	/**
	* Extrusion temperature in degree Celsius, set 0 to disable (default: 200)
	* @return int
	*/
	public function getTemperature() {
		return($this->Temperature);
	}
	/**
	* Extrusion temperature in degree Celsius, set 0 to disable (default: 200)
	* @param int $value
	*/
	public function setTemperature($value) {
		$this->Temperature = $value;
	}
	
	/**
	* Extrusion temperature for the first layer, in degree Celsius, set 0 to disable (default: same as --temperature)
	* @return int
	*/
	public function getFirstLayerTemperature() {
		return($this->FirstLayerTemperature);
	}
	/**
	* Extrusion temperature for the first layer, in degree Celsius, set 0 to disable (default: same as --temperature)
	* @param int $value
	*/
	public function setFirstLayerTemperature($value) {
		$this->FirstLayerTemperature = $value;
	}
	
	/**
	* Heated bed temperature in degree Celsius, set 0 to disable (default: 0)
	* @return int
	*/
	public function getBedTemperature() {
		return($this->BedTemperature);
	}
	/**
	* Heated bed temperature in degree Celsius, set 0 to disable (default: 0)
	* @param int $value
	*/
	public function setBedTemperature($value) {
		$this->BedTemperature = $value;
	}
	
	/**
	* Heated bed temperature for the first layer, in degree Celsius, set 0 to disable (default: same as --bed-temperature)
	* @return int
	*/
	public function getFirstLayerBedTemperature() {
		return($this->FirstLayerBedTemperature);
	}
	/**
	* Heated bed temperature for the first layer, in degree Celsius, set 0 to disable (default: same as --bed-temperature)
	* @param int $value
	*/
	public function setFirstLayerBedTemperature($value) {
		$this->FirstLayerBedTemperature = $value;
	}
	
	/**
	* Speed of non-print moves in mm/s (default: 130)
	* @return int
	*/
	public function getTravelSpeed() {
		return($this->TravelSpeed);
	}
	/**
	* Speed of non-print moves in mm/s (default: 130)
	* @param int $value
	*/
	public function setTravelSpeed($value) {
		$this->TravelSpeed = $value;
	}
	
	/**
	* Speed of print moves for perimeters in mm/s (default: 30)
	* @return int
	*/
	public function getPerimeterSpeed() {
		return($this->PerimeterSpeed);
	}
	/**
	* Speed of print moves for perimeters in mm/s (default: 30)
	* @param int $value
	*/
	public function setPerimeterSpeed($value) {
		$this->PerimeterSpeed = $value;
	}
	
	/**
	* Speed of print moves for small perimeters in mm/s or % over perimeter speed (default: 30)
	* @return int
	*/
	public function getSmallPerimeterSpeed() {
		return($this->SmallPerimeterSpeed);
	}
	/**
	* Speed of print moves for small perimeters in mm/s or % over perimeter speed (default: 30)
	* @param int $value
	*/
	public function setSmallPerimeterSpeed($value) {
		$this->SmallPerimeterSpeed = $value;
	}
	
	/**
	* Speed of print moves for the external perimeter in mm/s or % over perimeter speed (default: 70%)
	* @return int
	*/
	public function getExternalPerimeterSpeed() {
		return($this->ExternalPerimeterSpeed);
	}
	/**
	* Speed of print moves for the external perimeter in mm/s or % over perimeter speed (default: 70%)
	* @param int $value
	*/
	public function setExternalPerimeterSpeed($value) {
		$this->ExternalPerimeterSpeed = $value;
	}
	
	/**
	* Speed of print moves in mm/s (default: 60)
	* @return int
	*/
	public function getInfillSpeed() {
		return($this->InfillSpeed);
	}
	/**
	* Speed of print moves in mm/s (default: 60)
	* @param int $value
	*/
	public function setInfillSpeed($value) {
		$this->InfillSpeed = $value;
	}
	
	/**
	* Speed of print moves for solid surfaces in mm/s or % over infill speed (default: 60)
	* @return int
	*/
	public function getSolidInfillSpeed() {
		return($this->SolidInfillSpeed);
	}
	/**
	* Speed of print moves for solid surfaces in mm/s or % over infill speed (default: 60)
	* @param int $value
	*/
	public function setSolidInfillSpeed($value) {
		$this->SolidInfillSpeed = $value;
	}
	
	/**
	* Speed of print moves for top surfaces in mm/s or % over solid infill speed (default: 50)
	* @return int
	*/
	public function getTopSolidInfillSpeed() {
		return($this->TopSolidInfillSpeed);
	}
	/**
	* Speed of print moves for top surfaces in mm/s or % over solid infill speed (default: 50)
	* @param int $value
	*/
	public function setTopSolidInfillSpeed($value) {
		$this->TopSolidInfillSpeed = $value;
	}
	
	/**
	* Speed of support material print moves in mm/s (default: 60)
	* @return int
	*/
	public function getSupportMaterialSpeed() {
		return($this->SupportMaterialSpeed);
	}
	/**
	* Speed of support material print moves in mm/s (default: 60)
	* @param int $value
	*/
	public function setSupportMaterialSpeed($value) {
		$this->SupportMaterialSpeed = $value;
	}
	
	/**
	* Speed of bridge print moves in mm/s (default: 60)
	* @return int
	*/
	public function getBridgeSpeed() {
		return($this->BridgeSpeed);
	}
	/**
	* Speed of bridge print moves in mm/s (default: 60)
	* @param int $value
	*/
	public function setBridgeSpeed($value) {
		$this->BridgeSpeed = $value;
	}
	
	/**
	* Speed of gap fill print moves in mm/s (default: 20)
	* @return int
	*/
	public function getGapFillSpeed() {
		return($this->GapFillSpeed);
	}
	/**
	* Speed of gap fill print moves in mm/s (default: 20)
	* @param int $value
	*/
	public function setGapFillSpeed($value) {
		$this->GapFillSpeed = $value;
	}
	
	/**
	* Speed of print moves for bottom layer, expressed either as an absolute value or as a percentage over normal speeds (default: 30%)
	* @return int
	*/
	public function getFirstLayerSpeed() {
		return($this->FirstLayerSpeed);
	}
	/**
	* Speed of print moves for bottom layer, expressed either as an absolute value or as a percentage over normal speeds (default: 30%)
	* @param int $value
	*/
	public function setFirstLayerSpeed($value) {
		$this->FirstLayerSpeed = $value;
	}
	
	/**
	* Overrides firmware's default acceleration for perimeters. (mm/s^2, set zero to disable; default: 0)
	* @return int
	*/
	public function getPerimeterAcceleration() {
		return($this->PerimeterAcceleration);
	}
	/**
	* Overrides firmware's default acceleration for perimeters. (mm/s^2, set zero to disable; default: 0)
	* @param int $value
	*/
	public function setPerimeterAcceleration($value) {
		$this->PerimeterAcceleration = $value;
	}
	
	/**
	* Overrides firmware's default acceleration for infill. (mm/s^2, set zero to disable; default: 0)
	* @return int
	*/
	public function getInfillAcceleration() {
		return($this->InfillAcceleration);
	}
	/**
	* Overrides firmware's default acceleration for infill. (mm/s^2, set zero to disable; default: 0)
	* @param int $value
	*/
	public function setInfillAcceleration($value) {
		$this->InfillAcceleration = $value;
	}
	
	/**
	* Overrides firmware's default acceleration for bridges. (mm/s^2, set zero to disable; default: 0)
	* @return int
	*/
	public function getBridgeAcceleration() {
		return($this->BridgeAcceleration);
	}
	/**
	* Overrides firmware's default acceleration for bridges. (mm/s^2, set zero to disable; default: 0)
	* @param int $value
	*/
	public function setBridgeAcceleration($value) {
		$this->BridgeAcceleration = $value;
	}
	
	/**
	* Overrides firmware's default acceleration for first layer. (mm/s^2, set zero to disable; default: 0)
	* @return int
	*/
	public function getFirstLayerAcceleration() {
		return($this->FirstLayerAcceleration);
	}
	/**
	* Overrides firmware's default acceleration for first layer. (mm/s^2, set zero to disable; default: 0)
	* @param int $value
	*/
	public function setFirstLayerAcceleration($value) {
		$this->FirstLayerAcceleration = $value;
	}
	
	/**
	* Acceleration will be reset to this value after the specific settings above have been applied. (mm/s^2, set zero to disable; default: 130)
	* @return int
	*/
	public function getDefaultAcceleration() {
		return($this->DefaultAcceleration);
	}
	/**
	* Acceleration will be reset to this value after the specific settings above have been applied. (mm/s^2, set zero to disable; default: 130)
	* @param int $value
	*/
	public function setDefaultAcceleration($value) {
		$this->DefaultAcceleration = $value;
	}
	
	/**
	* Layer height in mm (default: 0.4)
	* @return float
	*/
	public function getLayerHeight() {
		return($this->LayerHeight);
	}
	/**
	* Layer height in mm (default: 0.4)
	* @param float $value
	*/
	public function setLayerHeight($value) {
		$this->LayerHeight = $value;
	}
	
	/**
	* Layer height for first layer (mm or %, default: 0.35)
	* @return float
	*/
	public function getFirstLayerHeight() {
		return($this->FirstLayerHeight);
	}
	/**
	* Layer height for first layer (mm or %, default: 0.35)
	* @param float $value
	*/
	public function setFirstLayerHeight($value) {
		$this->FirstLayerHeight = $value;
	}
	
	/**
	* Infill every N layers (default: 1)
	* @return int
	*/
	public function getInfillEveryLayer() {
		return($this->InfillEveryLayer);
	}
	/**
	* Infill every N layers (default: 1)
	* @param int $value
	*/
	public function setInfillEveryLayer($value) {
		$this->InfillEveryLayer = $value;
	}
	
	/**
	* Force a solid layer every N layers (default: 0)
	* @return int
	*/
	public function getSolidInfillEveryLayers() {
		return($this->SolidInfillEveryLayers);
	}
	/**
	* Force a solid layer every N layers (default: 0)
	* @param int $value
	*/
	public function setSolidInfillEveryLayers($value) {
		$this->SolidInfillEveryLayers = $value;
	}
	
	/**
	* Number of perimeters/horizontal skins (range: 0+, default: 3)
	* @return int
	*/
	public function getPerimeters() {
		return($this->Perimeters);
	}
	/**
	* Number of perimeters/horizontal skins (range: 0+, default: 3)
	* @param int $value
	*/
	public function setPerimeters($value) {
		$this->Perimeters = $value;
	}
	
	/**
	* Number of solid layers to do for top surfaces (range: 0+, default: 3)
	* @return int
	*/
	public function getTopSolidLayers() {
		return($this->TopSolidLayers);
	}
	/**
	* Number of solid layers to do for top surfaces (range: 0+, default: 3)
	* @param int $value
	*/
	public function setTopSolidLayers($value) {
		$this->TopSolidLayers = $value;
	}
	
	/**
	* Number of solid layers to do for bottom surfaces (range: 0+, default: 3)
	* @return int
	*/
	public function getBottomSolidLayers() {
		return($this->BottomSolidLayers);
	}
	/**
	* Number of solid layers to do for bottom surfaces (range: 0+, default: 3)
	* @param int $value
	*/
	public function setBottomSolidLayers($value) {
		$this->BottomSolidLayers = $value;
	}
	
	/**
	* Shortcut for setting the two options above at once
	* @return boolean
	*/
	public function getSolidLayers() {
		return($this->SolidLayers);
	}
	/**
	* Shortcut for setting the two options above at once
	* @param boolean $value
	*/
	public function setSolidLayers($value) {
		$this->SolidLayers = $value;
	}
	
	/**
	* Infill density (range: 0-1, default: 0.4)
	* @return float
	*/
	public function getFillDensity() {
		return($this->FillDensity);
	}
	/**
	* Infill density (range: 0-1, default: 0.4)
	* @param float $value
	*/
	public function setFillDensity($value) {
		$this->FillDensity = $value;
	}
	
	/**
	* Infill angle in degrees (range: 0-90, default: 45)
	* @return int
	*/
	public function getFillAngle() {
		return($this->FillAngle);
	}
	/**
	* Infill angle in degrees (range: 0-90, default: 45)
	* @param int $value
	*/
	public function setFillAngle($value) {
		$this->FillAngle = $value;
	}
	
	/**
	* Pattern to use to fill non-solid layers (default: honeycomb)
	* @return string
	*/
	public function getFillPattern() {
		return($this->FillPattern);
	}
	/**
	* Pattern to use to fill non-solid layers (default: honeycomb)
	* @param string $value
	*/
	public function setFillPattern($value) {
		$this->FillPattern = $value;
	}
	
	/**
	* Pattern to use to fill solid layers (default: rectilinear)
	* @return string
	*/
	public function getSolidFillPattern() {
		return($this->SolidFillPattern);
	}
	/**
	* Pattern to use to fill solid layers (default: rectilinear)
	* @param string $value
	*/
	public function setSolidFillPattern($value) {
		$this->SolidFillPattern = $value;
	}
	
	/**
	* Load initial G-code from the supplied file. This will overwrite the default command (home all axes [G28]).
	* @return boolean
	*/
	public function getStartGCode() {
		return($this->StartGCode);
	}
	/**
	* Load initial G-code from the supplied file. This will overwrite the default command (home all axes [G28]).
	* @param boolean $value
	*/
	public function setStartGCode($value) {
		$this->StartGCode = $value;
	}
	
	/**
	* Load final G-code from the supplied file. This will overwrite the default commands (turn off temperature [M104 S0], home X axis [G28 X], disable motors [M84]).
	* @return boolean
	*/
	public function getEndGCode() {
		return($this->EndGCode);
	}
	/**
	* Load final G-code from the supplied file. This will overwrite the default commands (turn off temperature [M104 S0], home X axis [G28 X], disable motors [M84]).
	* @param boolean $value
	*/
	public function setEndGCode($value) {
		$this->EndGCode = $value;
	}
	
	/**
	* Load layer-change G-code from the supplied file (default: nothing).
	* @return boolean
	*/
	public function getLayerGCode() {
		return($this->LayerGCode);
	}
	/**
	* Load layer-change G-code from the supplied file (default: nothing).
	* @param boolean $value
	*/
	public function setLayerGCode($value) {
		$this->LayerGCode = $value;
	}
	
	/**
	* Load tool-change G-code from the supplied file (default: nothing).
	* @return boolean
	*/
	public function getToolChangeGCode() {
		return($this->ToolChangeGCode);
	}
	/**
	* Load tool-change G-code from the supplied file (default: nothing).
	* @param boolean $value
	*/
	public function setToolChangeGCode($value) {
		$this->ToolChangeGCode = $value;
	}
	
	/**
	* Randomize starting point across layers (default: yes)
	* @return boolean
	*/
	public function getRadomizeStart() {
		return($this->RadomizeStart);
	}
	/**
	* Randomize starting point across layers (default: yes)
	* @param boolean $value
	*/
	public function setRadomizeStart($value) {
		$this->RadomizeStart = $value;
	}
	
	/**
	* Reverse perimeter order. (default: no)
	* @return boolean
	*/
	public function getExternalPerimeterFirst() {
		return($this->ExternalPerimeterFirst);
	}
	/**
	* Reverse perimeter order. (default: no)
	* @param boolean $value
	*/
	public function setExternalPerimeterFirst($value) {
		$this->ExternalPerimeterFirst = $value;
	}
	
	/**
	* Experimental option to raise Z gradually when printing single-walled vases (default: no)
	* @return boolean
	*/
	public function getSpiralVase() {
		return($this->SpiralVase);
	}
	/**
	* Experimental option to raise Z gradually when printing single-walled vases (default: no)
	* @param boolean $value
	*/
	public function setSpiralVase($value) {
		$this->SpiralVase = $value;
	}
	
	/**
	* Disable retraction when travelling between infill paths inside the same island. (default: no)
	* @return boolean
	*/
	public function getOnlyRetractWhenCrossingPerimeters() {
		return($this->OnlyRetractWhenCrossingPerimeters);
	}
	/**
	* Disable retraction when travelling between infill paths inside the same island. (default: no)
	* @param boolean $value
	*/
	public function setOnlyRetractWhenCrossingPerimeters($value) {
		$this->OnlyRetractWhenCrossingPerimeters = $value;
	}
	
	/**
	* Force solid infill when a region has a smaller area than this threshold (mm^2, default: 70)
	* @return int
	*/
	public function getSolidInfillBelowArea() {
		return($this->SolidInfillBelowArea);
	}
	/**
	* Force solid infill when a region has a smaller area than this threshold (mm^2, default: 70)
	* @param int $value
	*/
	public function setSolidInfillBelowArea($value) {
		$this->SolidInfillBelowArea = $value;
	}
	
	/**
	* Only infill under ceilings (default: no)
	* @return boolean
	*/
	public function getInfillOnlyWhereNeeded() {
		return($this->InfillOnlyWhereNeeded);
	}
	/**
	* Only infill under ceilings (default: no)
	* @param boolean $value
	*/
	public function setInfillOnlyWhereNeeded($value) {
		$this->InfillOnlyWhereNeeded = $value;
	}
	
	/**
	* Make infill before perimeters (default: no)
	* @return boolean
	*/
	public function getInfillFirst() {
		return($this->InfillFirst);
	}
	/**
	* Make infill before perimeters (default: no)
	* @param boolean $value
	*/
	public function setInfillFirst($value) {
		$this->InfillFirst = $value;
	}
	
	/**
	* Add more perimeters when needed (default: yes)
	* @return boolean
	*/
	public function getExtraPerimeters() {
		return($this->ExtraPerimeters);
	}
	/**
	* Add more perimeters when needed (default: yes)
	* @param boolean $value
	*/
	public function setExtraPerimeters($value) {
		$this->ExtraPerimeters = $value;
	}
	
	/**
	* Optimize travel moves so that no perimeters are crossed (default: no)
	* @return boolean
	*/
	public function getAvoidCrossingPerimeters() {
		return($this->AvoidCrossingPerimeters);
	}
	/**
	* Optimize travel moves so that no perimeters are crossed (default: no)
	* @param boolean $value
	*/
	public function setAvoidCrossingPerimeters($value) {
		$this->AvoidCrossingPerimeters = $value;
	}
	
	/**
	* Try to start perimeters at concave points if any (default: no)
	* @return boolean
	*/
	public function getStartPerimetersAtConcavePoints() {
		return($this->StartPerimetersAtConcavePoints);
	}
	/**
	* Try to start perimeters at concave points if any (default: no)
	* @param boolean $value
	*/
	public function setStartPerimetersAtConcavePoints($value) {
		$this->StartPerimetersAtConcavePoints = $value;
	}
	
	/**
	* Try to start perimeters at non-overhang points if any (default: no)
	* @return boolean
	*/
	public function getStartPerimetersAtNonOverhang() {
		return($this->StartPerimetersAtNonOverhang);
	}
	/**
	* Try to start perimeters at non-overhang points if any (default: no)
	* @param boolean $value
	*/
	public function setStartPerimetersAtNonOverhang($value) {
		$this->StartPerimetersAtNonOverhang = $value;
	}
	
	/**
	* Detect single-width walls (default: yes)
	* @return boolean
	*/
	public function getThinWalls() {
		return($this->ThinWalls);
	}
	/**
	* Detect single-width walls (default: yes)
	* @param boolean $value
	*/
	public function setThinWalls($value) {
		$this->ThinWalls = $value;
	}
	
	/**
	* Experimental option to use bridge flow, speed and fan for overhangs (default: yes)
	* @return boolean
	*/
	public function getOverHangs() {
		return($this->OverHangs);
	}
	/**
	* Experimental option to use bridge flow, speed and fan for overhangs (default: yes)
	* @param boolean $value
	*/
	public function setOverHangs($value) {
		$this->OverHangs = $value;
	}
	
	/**
	* Generate support material for overhangs
	* @return boolean
	*/
	public function getSupportMaterial() {
		return($this->SupportMaterial);
	}
	/**
	* Generate support material for overhangs
	* @param boolean $value
	*/
	public function setSupportMaterial($value) {
		$this->SupportMaterial = $value;
	}
	
	/**
	* Overhang threshold angle (range: 0-90, set 0 for automatic detection, default: 0)
	* @return int
	*/
	public function getSupportMaterialThreshold() {
		return($this->SupportMaterialThreshold);
	}
	/**
	* Overhang threshold angle (range: 0-90, set 0 for automatic detection, default: 0)
	* @param int $value
	*/
	public function setSupportMaterialThreshold($value) {
		$this->SupportMaterialThreshold = $value;
	}
	
	/**
	* Pattern to use for support material (default: honeycomb)
	* @return string
	*/
	public function getSupportMaterialPattern() {
		return($this->SupportMaterialPattern);
	}
	/**
	* Pattern to use for support material (default: honeycomb)
	* @param string $value
	*/
	public function setSupportMaterialPattern($value) {
		$this->SupportMaterialPattern = $value;
	}
	
	/**
	* Spacing between pattern lines (mm, default: 2.5)
	* @return float
	*/
	public function getSupportMaterialSpacing() {
		return($this->SupportMaterialSpacing);
	}
	/**
	* Spacing between pattern lines (mm, default: 2.5)
	* @param float $value
	*/
	public function setSupportMaterialSpacing($value) {
		$this->SupportMaterialSpacing = $value;
	}
	
	/**
	* Support material angle in degrees (range: 0-90, default: 0)
	* @return int
	*/
	public function getSupportMaterialAngle() {
		return($this->SupportMaterialAngle);
	}
	/**
	* Support material angle in degrees (range: 0-90, default: 0)
	* @param int $value
	*/
	public function setSupportMaterialAngle($value) {
		$this->SupportMaterialAngle = $value;
	}
	
	/**
	* Number of perpendicular layers between support material and object (0+, default: 3)
	* @return int
	*/
	public function getSupportMaterialInterfaceLayers() {
		return($this->SupportMaterialInterfaceLayers);
	}
	/**
	* Number of perpendicular layers between support material and object (0+, default: 3)
	* @param int $value
	*/
	public function setSupportMaterialInterfaceLayers($value) {
		$this->SupportMaterialInterfaceLayers = $value;
	}
	
	/**
	* Spacing between interface pattern lines (mm, set 0 to get a solid layer, default: 0)
	* @return int
	*/
	public function getSupportMaterialInterfaceSpacing() {
		return($this->SupportMaterialInterfaceSpacing);
	}
	/**
	* Spacing between interface pattern lines (mm, set 0 to get a solid layer, default: 0)
	* @param int $value
	*/
	public function setSupportMaterialInterfaceSpacing($value) {
		$this->SupportMaterialInterfaceSpacing = $value;
	}
	
	/**
	* Number of layers to raise the printed objects by (range: 0+, default: 0)
	* @return int
	*/
	public function getRaftLayers() {
		return($this->RaftLayers);
	}
	/**
	* Number of layers to raise the printed objects by (range: 0+, default: 0)
	* @param int $value
	*/
	public function setRaftLayers($value) {
		$this->RaftLayers = $value;
	}
	
	/**
	* Enforce support material on the specified number of layers from bottom, regardless of --support-material and threshold (0+, default: 0)
	* @return int
	*/
	public function getSupportMaterialEnforceLayers() {
		return($this->SupportMaterialEnforceLayers);
	}
	/**
	* Enforce support material on the specified number of layers from bottom, regardless of --support-material and threshold (0+, default: 0)
	* @param int $value
	*/
	public function setSupportMaterialEnforceLayers($value) {
		$this->SupportMaterialEnforceLayers = $value;
	}
	
	/**
	* Length of retraction in mm when pausing extrusion (default: 1)
	* @return int
	*/
	public function getRetractLength() {
		return($this->RetractLength);
	}
	/**
	* Length of retraction in mm when pausing extrusion (default: 1)
	* @param int $value
	*/
	public function setRetractLength($value) {
		$this->RetractLength = $value;
	}
	
	/**
	* Speed for retraction in mm/s (default: 30)
	* @return int
	*/
	public function getRetractSpeed() {
		return($this->RetractSpeed);
	}
	/**
	* Speed for retraction in mm/s (default: 30)
	* @param int $value
	*/
	public function setRetractSpeed($value) {
		$this->RetractSpeed = $value;
	}
	
	/**
	* Additional amount of filament in mm to push after compensating retraction (default: 0)
	* @return int
	*/
	public function getRetractRestartExtra() {
		return($this->RetractRestartExtra);
	}
	/**
	* Additional amount of filament in mm to push after compensating retraction (default: 0)
	* @param int $value
	*/
	public function setRetractRestartExtra($value) {
		$this->RetractRestartExtra = $value;
	}
	
	/**
	* Only retract before travel moves of this length in mm (default: 2)
	* @return int
	*/
	public function getRetractBeforeTravel() {
		return($this->RetractBeforeTravel);
	}
	/**
	* Only retract before travel moves of this length in mm (default: 2)
	* @param int $value
	*/
	public function setRetractBeforeTravel($value) {
		$this->RetractBeforeTravel = $value;
	}
	
	/**
	* Lift Z by the given distance in mm when retracting (default: 0)
	* @return int
	*/
	public function getRetractLift() {
		return($this->RetractLift);
	}
	/**
	* Lift Z by the given distance in mm when retracting (default: 0)
	* @param int $value
	*/
	public function setRetractLift($value) {
		$this->RetractLift = $value;
	}
	
	/**
	* Enforce a retraction before each Z move (default: yes)
	* @return boolean
	*/
	public function getRetractLayerChange() {
		return($this->RetractLayerChange);
	}
	/**
	* Enforce a retraction before each Z move (default: yes)
	* @param boolean $value
	*/
	public function setRetractLayerChange($value) {
		$this->RetractLayerChange = $value;
	}
	
	/**
	* Wipe the nozzle while doing a retraction (default: no)
	* @return boolean
	*/
	public function getWipe() {
		return($this->Wipe);
	}
	/**
	* Wipe the nozzle while doing a retraction (default: no)
	* @param boolean $value
	*/
	public function setWipe($value) {
		$this->Wipe = $value;
	}
	
	/**
	* Length of retraction in mm when disabling tool (default: 1)
	* @return int
	*/
	public function getRetractLengthToolChange() {
		return($this->RetractLengthToolChange);
	}
	/**
	* Length of retraction in mm when disabling tool (default: 1)
	* @param int $value
	*/
	public function setRetractLengthToolChange($value) {
		$this->RetractLengthToolChange = $value;
	}
	
	/**
	* Additional amount of filament in mm to push after switching tool (default: 0)
	* @return int
	*/
	public function getRetractRestartExtraToolChange() {
		return($this->RetractRestartExtraToolChange);
	}
	/**
	* Additional amount of filament in mm to push after switching tool (default: 0)
	* @param int $value
	*/
	public function setRetractRestartExtraToolChange($value) {
		$this->RetractRestartExtraToolChange = $value;
	}
	
	/**
	* Enable fan and cooling control
	* @return boolean
	*/
	public function getCooling() {
		return($this->Cooling);
	}
	/**
	* Enable fan and cooling control
	* @param boolean $value
	*/
	public function setCooling($value) {
		$this->Cooling = $value;
	}
	
	/**
	* Minimum fan speed (default: 35%)
	* @return int
	*/
	public function getMinFanSpeed() {
		return($this->MinFanSpeed);
	}
	/**
	* Minimum fan speed (default: 35%)
	* @param int $value
	*/
	public function setMinFanSpeed($value) {
		$this->MinFanSpeed = $value;
	}
	
	/**
	* Maximum fan speed (default: 100%)
	* @return int
	*/
	public function getMaxFanSpeed() {
		return($this->MaxFanSpeed);
	}
	/**
	* Maximum fan speed (default: 100%)
	* @param int $value
	*/
	public function setMaxFanSpeed($value) {
		$this->MaxFanSpeed = $value;
	}
	
	/**
	* Fan speed to use when bridging (default: 100%)
	* @return int
	*/
	public function getBridgeFanSpeed() {
		return($this->BridgeFanSpeed);
	}
	/**
	* Fan speed to use when bridging (default: 100%)
	* @param int $value
	*/
	public function setBridgeFanSpeed($value) {
		$this->BridgeFanSpeed = $value;
	}
	
	/**
	* Enable fan if layer print time is below this approximate number  of seconds (default: 60)
	* @return int
	*/
	public function getFanBelowLayerTime() {
		return($this->FanBelowLayerTime);
	}
	/**
	* Enable fan if layer print time is below this approximate number  of seconds (default: 60)
	* @param int $value
	*/
	public function setFanBelowLayerTime($value) {
		$this->FanBelowLayerTime = $value;
	}
	
	/**
	* Slow down if layer print time is below this approximate number of seconds (default: 30)
	* @return int
	*/
	public function getSlowdownBelowLayerTime() {
		return($this->SlowdownBelowLayerTime);
	}
	/**
	* Slow down if layer print time is below this approximate number of seconds (default: 30)
	* @param int $value
	*/
	public function setSlowdownBelowLayerTime($value) {
		$this->SlowdownBelowLayerTime = $value;
	}
	
	/**
	* Minimum print speed (mm/s, default: 10)
	* @return int
	*/
	public function getMinPrintSpeed() {
		return($this->MinPrintSpeed);
	}
	/**
	* Minimum print speed (mm/s, default: 10)
	* @param int $value
	*/
	public function setMinPrintSpeed($value) {
		$this->MinPrintSpeed = $value;
	}
	
	/**
	* Disable fan for the first N layers (default: 1)
	* @return int
	*/
	public function getDisableFanFirstLayers() {
		return($this->DisableFanFirstLayers);
	}
	/**
	* Disable fan for the first N layers (default: 1)
	* @param int $value
	*/
	public function setDisableFanFirstLayers($value) {
		$this->DisableFanFirstLayers = $value;
	}
	
	/**
	* Keep fan always on at min fan speed, even for layers that don't need cooling
	* @return boolean
	*/
	public function getFanAlwaysOn() {
		return($this->FanAlwaysOn);
	}
	/**
	* Keep fan always on at min fan speed, even for layers that don't need cooling
	* @param boolean $value
	*/
	public function setFanAlwaysOn($value) {
		$this->FanAlwaysOn = $value;
	}
	
	/**
	* Number of skirts to draw (0+, default: 1)
	* @return int
	*/
	public function getSkirts() {
		return($this->Skirts);
	}
	/**
	* Number of skirts to draw (0+, default: 1)
	* @param int $value
	*/
	public function setSkirts($value) {
		$this->Skirts = $value;
	}
	
	/**
	* Distance in mm between innermost skirt and object (default: 6)
	* @return int
	*/
	public function getSkirtDistance() {
		return($this->SkirtDistance);
	}
	/**
	* Distance in mm between innermost skirt and object (default: 6)
	* @param int $value
	*/
	public function setSkirtDistance($value) {
		$this->SkirtDistance = $value;
	}
	
	/**
	* Height of skirts to draw (expressed in layers, 0+, default: 1)
	* @return int
	*/
	public function getSkirtHeight() {
		return($this->SkirtHeight);
	}
	/**
	* Height of skirts to draw (expressed in layers, 0+, default: 1)
	* @param int $value
	*/
	public function setSkirtHeight($value) {
		$this->SkirtHeight = $value;
	}
	
	/**
	* Generate no less than the number of loops required to consume this length of filament on the first layer, for each extruder (mm, 0+, default: 0)
	* @return int
	*/
	public function getMinSkirtLength() {
		return($this->MinSkirtLength);
	}
	/**
	* Generate no less than the number of loops required to consume this length of filament on the first layer, for each extruder (mm, 0+, default: 0)
	* @param int $value
	*/
	public function setMinSkirtLength($value) {
		$this->MinSkirtLength = $value;
	}
	
	/**
	* Width of the brim that will get added to each object to help adhesion (mm, default: 0)
	* @return int
	*/
	public function getBrimWidth() {
		return($this->BrimWidth);
	}
	/**
	* Width of the brim that will get added to each object to help adhesion (mm, default: 0)
	* @param int $value
	*/
	public function setBrimWidth($value) {
		$this->BrimWidth = $value;
	}
	
	/**
	* Factor for scaling input object (default: 1)
	* @return int
	*/
	public function getScale() {
		return($this->Scale);
	}
	/**
	* Factor for scaling input object (default: 1)
	* @param int $value
	*/
	public function setScale($value) {
		$this->Scale = $value;
	}
	
	/**
	* Rotation angle in degrees (0-360, default: 0)
	* @return int
	*/
	public function getRotate() {
		return($this->Rotate);
	}
	/**
	* Rotation angle in degrees (0-360, default: 0)
	* @param int $value
	*/
	public function setRotate($value) {
		$this->Rotate = $value;
	}
	
	/**
	* Number of items with auto-arrange (1+, default: 1)
	* @return int
	*/
	public function getDuplicate() {
		return($this->Duplicate);
	}
	/**
	* Number of items with auto-arrange (1+, default: 1)
	* @param int $value
	*/
	public function setDuplicate($value) {
		$this->Duplicate = $value;
	}
	
	/**
	* Bed size, only used for auto-arrange (mm, default: 200,200)
	* @return string
	*/
	public function getBedSize() {
		return($this->BedSize);
	}
	/**
	* Bed size, only used for auto-arrange (mm, default: 200,200)
	* @param string $value
	*/
	public function setBedSize($value) {
		$this->BedSize = $value;
	}
	
	/**
	* Number of items with grid arrangement (default: 1,1)
	* @return string
	*/
	public function getDuplicateGrid() {
		return($this->DuplicateGrid);
	}
	/**
	* Number of items with grid arrangement (default: 1,1)
	* @param string $value
	*/
	public function setDuplicateGrid($value) {
		$this->DuplicateGrid = $value;
	}
	
	/**
	* Distance in mm between copies (default: 6)
	* @return int
	*/
	public function getDuplicateDistance() {
		return($this->DuplicateDistance);
	}
	/**
	* Distance in mm between copies (default: 6)
	* @param int $value
	*/
	public function setDuplicateDistance($value) {
		$this->DuplicateDistance = $value;
	}
	
	/**
	* When printing multiple objects and/or copies, complete each one before starting the next one; watch out for extruder collisions (default: no)
	* @return boolean
	*/
	public function getCompleteObjects() {
		return($this->CompleteObjects);
	}
	/**
	* When printing multiple objects and/or copies, complete each one before starting the next one; watch out for extruder collisions (default: no)
	* @param boolean $value
	*/
	public function setCompleteObjects($value) {
		$this->CompleteObjects = $value;
	}
	
	/**
	* Radius in mm above which extruder won't collide with anything (default: 20)
	* @return int
	*/
	public function getExtrudeClearanceRadius() {
		return($this->ExtrudeClearanceRadius);
	}
	/**
	* Radius in mm above which extruder won't collide with anything (default: 20)
	* @param int $value
	*/
	public function setExtrudeClearanceRadius($value) {
		$this->ExtrudeClearanceRadius = $value;
	}
	
	/**
	* Maximum vertical extruder depth; i.e. vertical distance from extruder tip and carriage bottom (default: 20)
	* @return int
	*/
	public function getExtrudeClearanceHeight() {
		return($this->ExtrudeClearanceHeight);
	}
	/**
	* Maximum vertical extruder depth; i.e. vertical distance from extruder tip and carriage bottom (default: 20)
	* @param int $value
	*/
	public function setExtrudeClearanceHeight($value) {
		$this->ExtrudeClearanceHeight = $value;
	}
	
	/**
	* Notes to be added as comments to the output file
	* @return string
	*/
	public function getNotes() {
		return($this->Notes);
	}
	/**
	* Notes to be added as comments to the output file
	* @param string $value
	*/
	public function setNotes($value) {
		$this->Notes = $value;
	}
	
	/**
	* Minimum detail resolution (mm, set zero for full resolution, default: 0)
	* @return int
	*/
	public function getResolution() {
		return($this->Resolution);
	}
	/**
	* Minimum detail resolution (mm, set zero for full resolution, default: 0)
	* @param int $value
	*/
	public function setResolution($value) {
		$this->Resolution = $value;
	}
	
	/**
	* Set extrusion width manually; it accepts either an absolute value in mm (like 0.65) or a percentage over layer height (like 200%)
	* @return string
	*/
	public function getExtrusionWidth() {
		return($this->ExtrusionWidth);
	}
	/**
	* Set extrusion width manually; it accepts either an absolute value in mm (like 0.65) or a percentage over layer height (like 200%)
	* @param string $value
	*/
	public function setExtrusionWidth($value) {
		$this->ExtrusionWidth = $value;
	}
	
	/**
	* Set a different extrusion width for first layer
	* @return string
	*/
	public function getFirstLayerExtrusionWidth() {
		return($this->FirstLayerExtrusionWidth);
	}
	/**
	* Set a different extrusion width for first layer
	* @param string $value
	*/
	public function setFirstLayerExtrusionWidth($value) {
		$this->FirstLayerExtrusionWidth = $value;
	}
	
	/**
	* Set a different extrusion width for perimeters
	* @return string
	*/
	public function getPerimeterExtrusionWidth() {
		return($this->PerimeterExtrusionWidth);
	}
	/**
	* Set a different extrusion width for perimeters
	* @param string $value
	*/
	public function setPerimeterExtrusionWidth($value) {
		$this->PerimeterExtrusionWidth = $value;
	}
	
	/**
	* Set a different extrusion width for infill
	* @return string
	*/
	public function getInfillExtrusionWidth() {
		return($this->InfillExtrusionWidth);
	}
	/**
	* Set a different extrusion width for infill
	* @param string $value
	*/
	public function setInfillExtrusionWidth($value) {
		$this->InfillExtrusionWidth = $value;
	}
	
	/**
	* Set a different extrusion width for solid infill
	* @return string
	*/
	public function getSolidInfillExtrusionWidth() {
		return($this->SolidInfillExtrusionWidth);
	}
	/**
	* Set a different extrusion width for solid infill
	* @param string $value
	*/
	public function setSolidInfillExtrusionWidth($value) {
		$this->SolidInfillExtrusionWidth = $value;
	}
	
	/**
	* Set a different extrusion width for top infill
	* @return string
	*/
	public function getTopInfillExtrusionWidth() {
		return($this->TopInfillExtrusionWidth);
	}
	/**
	* Set a different extrusion width for top infill
	* @param string $value
	*/
	public function setTopInfillExtrusionWidth($value) {
		$this->TopInfillExtrusionWidth = $value;
	}
	
	/**
	* Set a different extrusion width for support material
	* @return string
	*/
	public function getSupportMaterialExtrusionWidth() {
		return($this->SupportMaterialExtrusionWidth);
	}
	/**
	* Set a different extrusion width for support material
	* @param string $value
	*/
	public function setSupportMaterialExtrusionWidth($value) {
		$this->SupportMaterialExtrusionWidth = $value;
	}
	
	/**
	* Multiplier for extrusion when bridging (&gt; 0, default: 1)
	* @return int
	*/
	public function getBridgeFlowRatio() {
		return($this->BridgeFlowRatio);
	}
	/**
	* Multiplier for extrusion when bridging (&gt; 0, default: 1)
	* @param int $value
	*/
	public function setBridgeFlowRatio($value) {
		$this->BridgeFlowRatio = $value;
	}
	
	/**
	* Offset of each extruder, if firmware doesn't handle the displacement (can be specified multiple times, default: 0x0)
	* @return string
	*/
	public function getExtruderOffset() {
		return($this->ExtruderOffset);
	}
	/**
	* Offset of each extruder, if firmware doesn't handle the displacement (can be specified multiple times, default: 0x0)
	* @param string $value
	*/
	public function setExtruderOffset($value) {
		$this->ExtruderOffset = $value;
	}
	
	/**
	* Extruder to use for perimeters (1+, default: 1)
	* @return int
	*/
	public function getPerimeterExtruder() {
		return($this->PerimeterExtruder);
	}
	/**
	* Extruder to use for perimeters (1+, default: 1)
	* @param int $value
	*/
	public function setPerimeterExtruder($value) {
		$this->PerimeterExtruder = $value;
	}
	
	/**
	* Extruder to use for infill (1+, default: 1)
	* @return int
	*/
	public function getInfillExtruder() {
		return($this->InfillExtruder);
	}
	/**
	* Extruder to use for infill (1+, default: 1)
	* @param int $value
	*/
	public function setInfillExtruder($value) {
		$this->InfillExtruder = $value;
	}
	
	/**
	* Extruder to use for support material (1+, default: 1)
	* @return int
	*/
	public function getSupportMaterialExtruder() {
		return($this->SupportMaterialExtruder);
	}
	/**
	* Extruder to use for support material (1+, default: 1)
	* @param int $value
	*/
	public function setSupportMaterialExtruder($value) {
		$this->SupportMaterialExtruder = $value;
	}
	
	/**
	* Extruder to use for support material interface (1+, default: 1)
	* @return int
	*/
	public function getSupportMaterialInterfaceExtruder() {
		return($this->SupportMaterialInterfaceExtruder);
	}
	/**
	* Extruder to use for support material interface (1+, default: 1)
	* @param int $value
	*/
	public function setSupportMaterialInterfaceExtruder($value) {
		$this->SupportMaterialInterfaceExtruder = $value;
	}
	
	/**
	* Drop temperature and park extruders outside a full skirt for automatic wiping (default: no)
	* @return boolean
	*/
	public function getOozePrevention() {
		return($this->OozePrevention);
	}
	/**
	* Drop temperature and park extruders outside a full skirt for automatic wiping (default: no)
	* @param boolean $value
	*/
	public function setOozePrevention($value) {
		$this->OozePrevention = $value;
	}
	
	/**
	* Temperature difference to be applied when an extruder is not active and --ooze-prevention is enabled (default: -5)
	* @return int
	*/
	public function getStandbyTemperatureDelta() {
		return($this->StandbyTemperatureDelta);
	}
	/**
	* Temperature difference to be applied when an extruder is not active and --ooze-prevention is enabled (default: -5)
	* @param int $value
	*/
	public function setStandbyTemperatureDelta($value) {
		$this->StandbyTemperatureDelta = $value;
	}
	
	/**
	* Axis of the extrusion (Undocumented)
	* @return string
	*/
	public function getExtrusionAxis() {
		return($this->ExtrusionAxis);
	}
	/**
	* Axis of the extrusion (Undocumented)
	* @param string $value
	*/
	public function setExtrusionAxis($value) {
		$this->ExtrusionAxis = $value;
	}
	
	/**
	* Number of Slic3r threads to run (Undocumented)
	* @return int
	*/
	public function getThreads() {
		return($this->Threads);
	}
	/**
	* Number of Slic3r threads to run (Undocumented)
	* @param int $value
	*/
	public function setThreads($value) {
		$this->Threads = $value;
	}
	

	private function _composeCommand() {
		$result = $this->Command;
		
		if (isset($this->ConfigFileName)) {
			$result .= " --load " . $this->ConfigFileName;
		}
		if (isset($this->OutputFilename)) {
			$result .= " --output " . $this->OutputFilename;
		}
		if (isset($this->OutputFilenameFormat)) {
			$result .= " --output-filename-format " . $this->OutputFilenameFormat;
		}
		if (isset($this->PostProcess)) {
			$result .= " --post-process " . $this->PostProcess;
		}
		if (isset($this->ExportSVG)) {
			$result .= " --export-svg " . $this->ExportSVG;
		}
		if (isset($this->Merge)) {
			$result .= " --merge " . $this->Merge;
		}
		if (isset($this->NozzleDiameter)) {
			$result .= " --nozzle-diameter " . $this->NozzleDiameter;
		}
		if (isset($this->PrintCenter)) {
			$result .= " --print-center " . $this->PrintCenter;
		}
		if (isset($this->ZOffset)) {
			$result .= " --z-offset " . $this->ZOffset;
		}
		if (isset($this->GCodeFlavor)) {
			$result .= " --gcode-flavor " . $this->GCodeFlavor;
		}
		if (isset($this->UseRelativeEDistance)) {
			$result .= " --use-relative-e-distances " . $this->UseRelativeEDistance;
		}
		if (isset($this->UseFirmwareRetraction)) {
			$result .= " --use-firmware-retraction " . $this->UseFirmwareRetraction;
		}
		if (isset($this->GCodeArcs)) {
			$result .= " --gcode-arcs " . $this->GCodeArcs;
		}
		if (isset($this->G0)) {
			$result .= " --g0 " . $this->G0;
		}
		if (isset($this->GCodeComments)) {
			$result .= " --gcode-comments " . $this->GCodeComments;
		}
		if (isset($this->VibrationLimit)) {
			$result .= " --vibration-limit " . $this->VibrationLimit;
		}
		if (isset($this->FilamentDiameter)) {
			$result .= " --filament-diameter " . $this->FilamentDiameter;
		}
		if (isset($this->ExtrusionMultiplier)) {
			$result .= " --extrusion-multiplier " . $this->ExtrusionMultiplier;
		}
		if (isset($this->Temperature)) {
			$result .= " --temperature " . $this->Temperature;
		}
		if (isset($this->FirstLayerTemperature)) {
			$result .= " --first-layer-temperature " . $this->FirstLayerTemperature;
		}
		if (isset($this->BedTemperature)) {
			$result .= " --bed-temperature " . $this->BedTemperature;
		}
		if (isset($this->FirstLayerBedTemperature)) {
			$result .= " --first-layer-bed-temperature " . $this->FirstLayerBedTemperature;
		}
		if (isset($this->TravelSpeed)) {
			$result .= " --travel-speed " . $this->TravelSpeed;
		}
		if (isset($this->PerimeterSpeed)) {
			$result .= " --perimeter-speed " . $this->PerimeterSpeed;
		}
		if (isset($this->SmallPerimeterSpeed)) {
			$result .= " --small-perimeter-speed " . $this->SmallPerimeterSpeed;
		}
		if (isset($this->ExternalPerimeterSpeed)) {
			$result .= " --external-perimeter-speed " . $this->ExternalPerimeterSpeed;
		}
		if (isset($this->InfillSpeed)) {
			$result .= " --infill-speed " . $this->InfillSpeed;
		}
		if (isset($this->SolidInfillSpeed)) {
			$result .= " --solid-infill-speed " . $this->SolidInfillSpeed;
		}
		if (isset($this->TopSolidInfillSpeed)) {
			$result .= " --top-solid-infill-speed " . $this->TopSolidInfillSpeed;
		}
		if (isset($this->SupportMaterialSpeed)) {
			$result .= " --support-material-speed " . $this->SupportMaterialSpeed;
		}
		if (isset($this->BridgeSpeed)) {
			$result .= " --bridge-speed " . $this->BridgeSpeed;
		}
		if (isset($this->GapFillSpeed)) {
			$result .= " --gap-fill-speed " . $this->GapFillSpeed;
		}
		if (isset($this->FirstLayerSpeed)) {
			$result .= " --first-layer-speed " . $this->FirstLayerSpeed;
		}
		if (isset($this->PerimeterAcceleration)) {
			$result .= " --perimeter-acceleration " . $this->PerimeterAcceleration;
		}
		if (isset($this->InfillAcceleration)) {
			$result .= " --infill-acceleration " . $this->InfillAcceleration;
		}
		if (isset($this->BridgeAcceleration)) {
			$result .= " --bridge-acceleration " . $this->BridgeAcceleration;
		}
		if (isset($this->FirstLayerAcceleration)) {
			$result .= " --first-layer-acceleration " . $this->FirstLayerAcceleration;
		}
		if (isset($this->DefaultAcceleration)) {
			$result .= " --default-acceleration " . $this->DefaultAcceleration;
		}
		if (isset($this->LayerHeight)) {
			$result .= " --layer-height " . $this->LayerHeight;
		}
		if (isset($this->FirstLayerHeight)) {
			$result .= " --first-layer-height " . $this->FirstLayerHeight;
		}
		if (isset($this->InfillEveryLayer)) {
			$result .= " --infill-every-layers " . $this->InfillEveryLayer;
		}
		if (isset($this->SolidInfillEveryLayers)) {
			$result .= " --solid-infill-every-layers " . $this->SolidInfillEveryLayers;
		}
		if (isset($this->Perimeters)) {
			$result .= " --perimeters " . $this->Perimeters;
		}
		if (isset($this->TopSolidLayers)) {
			$result .= " --top-solid-layers " . $this->TopSolidLayers;
		}
		if (isset($this->BottomSolidLayers)) {
			$result .= " --bottom-solid-layers " . $this->BottomSolidLayers;
		}
		if (isset($this->SolidLayers)) {
			$result .= " --solid-layers " . $this->SolidLayers;
		}
		if (isset($this->FillDensity)) {
			$result .= " --fill-density " . $this->FillDensity;
		}
		if (isset($this->FillAngle)) {
			$result .= " --fill-angle " . $this->FillAngle;
		}
		if (isset($this->FillPattern)) {
			$result .= " --fill-pattern " . $this->FillPattern;
		}
		if (isset($this->SolidFillPattern)) {
			$result .= " --solid-fill-pattern " . $this->SolidFillPattern;
		}
		if (isset($this->StartGCode)) {
			$result .= " --start-gcode " . $this->StartGCode;
		}
		if (isset($this->EndGCode)) {
			$result .= " --end-gcode " . $this->EndGCode;
		}
		if (isset($this->LayerGCode)) {
			$result .= " --layer-gcode " . $this->LayerGCode;
		}
		if (isset($this->ToolChangeGCode)) {
			$result .= " --toolchange-gcode " . $this->ToolChangeGCode;
		}
		if (isset($this->RadomizeStart)) {
			$result .= " --randomize-start " . $this->RadomizeStart;
		}
		if (isset($this->ExternalPerimeterFirst)) {
			$result .= " --external-perimeters-first " . $this->ExternalPerimeterFirst;
		}
		if (isset($this->SpiralVase)) {
			$result .= " --spiral-vase " . $this->SpiralVase;
		}
		if (isset($this->OnlyRetractWhenCrossingPerimeters)) {
			$result .= " --only-retract-when-crossing-perimeters " . $this->OnlyRetractWhenCrossingPerimeters;
		}
		if (isset($this->SolidInfillBelowArea)) {
			$result .= " --solid-infill-below-area " . $this->SolidInfillBelowArea;
		}
		if (isset($this->InfillOnlyWhereNeeded)) {
			$result .= " --infill-only-where-needed " . $this->InfillOnlyWhereNeeded;
		}
		if (isset($this->InfillFirst)) {
			$result .= " --infill-first " . $this->InfillFirst;
		}
		if (isset($this->ExtraPerimeters)) {
			$result .= " --extra-perimeters " . $this->ExtraPerimeters;
		}
		if (isset($this->AvoidCrossingPerimeters)) {
			$result .= " --avoid-crossing-perimeters " . $this->AvoidCrossingPerimeters;
		}
		if (isset($this->StartPerimetersAtConcavePoints)) {
			$result .= " --start-perimeters-at-concave-points " . $this->StartPerimetersAtConcavePoints;
		}
		if (isset($this->StartPerimetersAtNonOverhang)) {
			$result .= " --start-perimeters-at-non-overhang " . $this->StartPerimetersAtNonOverhang;
		}
		if (isset($this->ThinWalls)) {
			$result .= " --thin-walls " . $this->ThinWalls;
		}
		if (isset($this->OverHangs)) {
			$result .= " --overhangs " . $this->OverHangs;
		}
		if (isset($this->SupportMaterial)) {
			$result .= " --support-material " . $this->SupportMaterial;
		}
		if (isset($this->SupportMaterialThreshold)) {
			$result .= " --support-material-threshold " . $this->SupportMaterialThreshold;
		}
		if (isset($this->SupportMaterialPattern)) {
			$result .= " --support-material-pattern " . $this->SupportMaterialPattern;
		}
		if (isset($this->SupportMaterialSpacing)) {
			$result .= " --support-material-spacing " . $this->SupportMaterialSpacing;
		}
		if (isset($this->SupportMaterialAngle)) {
			$result .= " --support-material-angle " . $this->SupportMaterialAngle;
		}
		if (isset($this->SupportMaterialInterfaceLayers)) {
			$result .= " --support-material-interface-layers " . $this->SupportMaterialInterfaceLayers;
		}
		if (isset($this->SupportMaterialInterfaceSpacing)) {
			$result .= " --support-material-interface-spacing " . $this->SupportMaterialInterfaceSpacing;
		}
		if (isset($this->RaftLayers)) {
			$result .= " --raft-layers " . $this->RaftLayers;
		}
		if (isset($this->SupportMaterialEnforceLayers)) {
			$result .= " --support-material-enforce-layers " . $this->SupportMaterialEnforceLayers;
		}
		if (isset($this->RetractLength)) {
			$result .= " --retract-length " . $this->RetractLength;
		}
		if (isset($this->RetractSpeed)) {
			$result .= " --retract-speed " . $this->RetractSpeed;
		}
		if (isset($this->RetractRestartExtra)) {
			$result .= " --retract-restart-extra " . $this->RetractRestartExtra;
		}
		if (isset($this->RetractBeforeTravel)) {
			$result .= " --retract-before-travel " . $this->RetractBeforeTravel;
		}
		if (isset($this->RetractLift)) {
			$result .= " --retract-lift " . $this->RetractLift;
		}
		if (isset($this->RetractLayerChange)) {
			$result .= " --retract-layer-change " . $this->RetractLayerChange;
		}
		if (isset($this->Wipe)) {
			$result .= " --wipe " . $this->Wipe;
		}
		if (isset($this->RetractLengthToolChange)) {
			$result .= " --retract-length-toolchange " . $this->RetractLengthToolChange;
		}
		if (isset($this->RetractRestartExtraToolChange)) {
			$result .= " --retract-restart-extra-toolchange " . $this->RetractRestartExtraToolChange;
		}
		if (isset($this->Cooling)) {
			$result .= " --cooling " . $this->Cooling;
		}
		if (isset($this->MinFanSpeed)) {
			$result .= " --min-fan-speed " . $this->MinFanSpeed;
		}
		if (isset($this->MaxFanSpeed)) {
			$result .= " --max-fan-speed " . $this->MaxFanSpeed;
		}
		if (isset($this->BridgeFanSpeed)) {
			$result .= " --bridge-fan-speed " . $this->BridgeFanSpeed;
		}
		if (isset($this->FanBelowLayerTime)) {
			$result .= " --fan-below-layer-time " . $this->FanBelowLayerTime;
		}
		if (isset($this->SlowdownBelowLayerTime)) {
			$result .= " --slowdown-below-layer-time " . $this->SlowdownBelowLayerTime;
		}
		if (isset($this->MinPrintSpeed)) {
			$result .= " --min-print-speed " . $this->MinPrintSpeed;
		}
		if (isset($this->DisableFanFirstLayers)) {
			$result .= " --disable-fan-first-layers " . $this->DisableFanFirstLayers;
		}
		if (isset($this->FanAlwaysOn)) {
			$result .= " --fan-always-on " . $this->FanAlwaysOn;
		}
		if (isset($this->Skirts)) {
			$result .= " --skirts " . $this->Skirts;
		}
		if (isset($this->SkirtDistance)) {
			$result .= " --skirt-distance " . $this->SkirtDistance;
		}
		if (isset($this->SkirtHeight)) {
			$result .= " --skirt-height " . $this->SkirtHeight;
		}
		if (isset($this->MinSkirtLength)) {
			$result .= " --min-skirt-length " . $this->MinSkirtLength;
		}
		if (isset($this->BrimWidth)) {
			$result .= " --brim-width " . $this->BrimWidth;
		}
		if (isset($this->Scale)) {
			$result .= " --scale " . $this->Scale;
		}
		if (isset($this->Rotate)) {
			$result .= " --rotate " . $this->Rotate;
		}
		if (isset($this->Duplicate)) {
			$result .= " --duplicate " . $this->Duplicate;
		}
		if (isset($this->BedSize)) {
			$result .= " --bed-size " . $this->BedSize;
		}
		if (isset($this->DuplicateGrid)) {
			$result .= " --duplicate-grid " . $this->DuplicateGrid;
		}
		if (isset($this->DuplicateDistance)) {
			$result .= " --duplicate-distance " . $this->DuplicateDistance;
		}
		if (isset($this->CompleteObjects)) {
			$result .= " --complete-objects " . $this->CompleteObjects;
		}
		if (isset($this->ExtrudeClearanceRadius)) {
			$result .= " --extruder-clearance-radius " . $this->ExtrudeClearanceRadius;
		}
		if (isset($this->ExtrudeClearanceHeight)) {
			$result .= " --extruder-clearance-height " . $this->ExtrudeClearanceHeight;
		}
		if (isset($this->Notes)) {
			$result .= " --notes " . $this->Notes;
		}
		if (isset($this->Resolution)) {
			$result .= " --resolution " . $this->Resolution;
		}
		if (isset($this->ExtrusionWidth)) {
			$result .= " --extrusion-width " . $this->ExtrusionWidth;
		}
		if (isset($this->FirstLayerExtrusionWidth)) {
			$result .= " --first-layer-extrusion-width " . $this->FirstLayerExtrusionWidth;
		}
		if (isset($this->PerimeterExtrusionWidth)) {
			$result .= " --perimeter-extrusion-width " . $this->PerimeterExtrusionWidth;
		}
		if (isset($this->InfillExtrusionWidth)) {
			$result .= " --infill-extrusion-width " . $this->InfillExtrusionWidth;
		}
		if (isset($this->SolidInfillExtrusionWidth)) {
			$result .= " --solid-infill-extrusion-width " . $this->SolidInfillExtrusionWidth;
		}
		if (isset($this->TopInfillExtrusionWidth)) {
			$result .= " --top-infill-extrusion-width " . $this->TopInfillExtrusionWidth;
		}
		if (isset($this->SupportMaterialExtrusionWidth)) {
			$result .= " --support-material-extrusion-width " . $this->SupportMaterialExtrusionWidth;
		}
		if (isset($this->BridgeFlowRatio)) {
			$result .= " --bridge-flow-ratio " . $this->BridgeFlowRatio;
		}
		if (isset($this->ExtruderOffset)) {
			$result .= " --extruder-offset " . $this->ExtruderOffset;
		}
		if (isset($this->PerimeterExtruder)) {
			$result .= " --perimeter-extruder " . $this->PerimeterExtruder;
		}
		if (isset($this->InfillExtruder)) {
			$result .= " --infill-extruder " . $this->InfillExtruder;
		}
		if (isset($this->SupportMaterialExtruder)) {
			$result .= " --support-material-extruder " . $this->SupportMaterialExtruder;
		}
		if (isset($this->SupportMaterialInterfaceExtruder)) {
			$result .= " --support-material-interface-extruder " . $this->SupportMaterialInterfaceExtruder;
		}
		if (isset($this->OozePrevention)) {
			$result .= " --ooze-prevention " . $this->OozePrevention;
		}
		if (isset($this->StandbyTemperatureDelta)) {
			$result .= " --standby-temperature-delta " . $this->StandbyTemperatureDelta;
		}
		if (isset($this->ExtrusionAxis)) {
			$result .= " --extrusion-axis " . $this->ExtrusionAxis;
		}
		if (isset($this->Threads)) {
			$result .= " --threads " . $this->Threads;
		}

		$result .= " " . $this->InputFilename;
		return($result);
	}
	
	
	/**
	* Get the command string that the execute() function runs
	* @return string
	*/
	public function getExecuteCommand() {
		return($this->_composeCommand());
	}
	
	/**
	* Execute the Slic3r and return the results
	* @return string
	*/
	public function execute(&$return_var) {
		$cmd = $this->_composeCommand() . " 2>&1";
		ob_start();
		passthru($cmd, $return_var);
		$ret = ob_get_clean();
		return($ret);
	}
}
<?php
/**
*	Slic3r execution class for PHP
*	Creation Date: February 2015
*	@author Jing Guo
*	@version 1.0
*/		
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\ConfigFile;
class Slic3rConfig extends Model
{
	  public $bed_size_x;
	  public $bed_size_y;
	  public $print_center_x;
	  public $print_center_y;
	  public $avoid_crossing_perimeters;
	  public $bed_size;
	  public $bed_temperature;
	  public $bottom_solid_layers;
	  public $bridge_acceleration;
	  public $bridge_fan_speed;
	  public $bridge_flow_ratio;
	  public $bridge_speed;
	  public $brim_width;
	  public $complete_objects;
	  public $cooling;
	  public $default_acceleration;
	  public $disable_fan_first_layers;
	  public $dont_support_bridges;
	  public $duplicate_distance;
	  public $end_gcode;
	  public $external_perimeter_speed;
	  public $external_perimeters_first;
	  public $extra_perimeters;
	  public $extruder_clearance_height;
	  public $extruder_clearance_radius;
	  public $extruder_offset;
	  public $extrusion_axis;
	  public $extrusion_multiplier;
	  public $extrusion_width;
	  public $fan_always_on;
	  public $fan_below_layer_time;
	  public $filament_diameter;
	  public $fill_angle;
	  public $fill_density;
	  public $fill_pattern;
	  public $first_layer_acceleration;
	  public $first_layer_bed_temperature;
	  public $first_layer_extrusion_width;
	  public $first_layer_height;
	  public $first_layer_speed;
	  public $first_layer_temperature;
	  public $g0;
	  public $gap_fill_speed;
	  public $gcode_arcs;
	  public $gcode_comments;
	  public $gcode_flavor;
	  public $infill_acceleration;
	  public $infill_every_layers;
	  public $infill_extruder;
	  public $infill_extrusion_width;
	  public $infill_first;
	  public $infill_only_where_needed;
	  public $infill_speed;
	  public $interface_shells;
	  public $layer_gcode;
	  public $layer_height;
	  public $max_fan_speed;
	  public $min_fan_speed;
	  public $min_print_speed;
	  public $min_skirt_length;
	  public $notes;
	  public $nozzle_diameter;
	  public $only_retract_when_crossing_perimeters;
	  public $ooze_prevention;
	  public $output_filename_format;
	  public $overhangs;
	  public $perimeter_acceleration;
	  public $perimeter_extruder;
	  public $perimeter_extrusion_width;
	  public $perimeter_speed;
	  public $perimeters;
	  public $post_process;
	  public $print_center;
	  public $raft_layers;
	  public $resolution;
	  public $retract_before_travel;
	  public $retract_layer_change;
	  public $retract_length;
	  public $retract_length_toolchange;
	  public $retract_lift;
	  public $retract_restart_extra;
	  public $retract_restart_extra_toolchange;
	  public $retract_speed;
	  public $seam_position;
	  public $skirt_distance;
	  public $skirt_height;
	  public $skirts;
	  public $slowdown_below_layer_time;
	  public $small_perimeter_speed;
	  public $solid_fill_pattern;
	  public $solid_infill_below_area;
	  public $solid_infill_every_layers;
	  public $solid_infill_extrusion_width;
	  public $solid_infill_speed;
	  public $spiral_vase;
	  public $standby_temperature_delta;
	  public $start_gcode;
	  public $support_material;
	  public $support_material_angle;
	  public $support_material_enforce_layers;
	  public $support_material_extruder;
	  public $support_material_extrusion_width;
	  public $support_material_interface_extruder;
	  public $support_material_interface_layers;
	  public $support_material_interface_spacing;
	  public $support_material_interface_speed;
	  public $support_material_pattern;
	  public $support_material_spacing;
	  public $support_material_speed;
	  public $support_material_threshold;
	  public $temperature;
	  public $thin_walls;
	  public $threads;
	  public $toolchange_gcode;
	  public $top_infill_extrusion_width;
	  public $top_solid_infill_speed;
	  public $top_solid_layers;
	  public $travel_speed;
	  public $use_firmware_retraction;
	  public $use_relative_e_distances;
	  public $vibration_limit;
	  public $wipe;
	  public $z_offset;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
			// Layer and Permister
			//[['layer_height', 'first_layer_height'],'number', 'max'=> 0.4, 'min'=> 0.05 ],
			[['layer_height', 'first_layer_height'],'compare', 'compareAttribute'=> $this->nozzle_diameter, 'compareValue'=>$this->nozzle_diameter, 'operator' => '<', 'message'=>Yii::t('Slic3r', 'Layer height must lest than Nozzle Diameter : '. $this->nozzle_diameter)],
			[['perimeters', 'spiral_vase', 'top_solid_layers', 'bottom_solid_layers', 'infill_only_where_needed', 'only_retract_when_crossing_perimeters','avoid_crossing_perimeters','extra_perimeters','thin_walls','overhangs','external_perimeters_first'], 'integer'],
			[['layer_height', 'first_layer_height', 'nozzle_diameter', 'perimeters', 'spiral_vase', 'top_solid_layers', 'bottom_solid_layers'],'number', 'min' => 0 ],
			//[['fill_density'], 'number', 'min'=>0, 'max'=>100],
			[['fill_pattern', 'solid_fill_pattern','seam_position'], 'string'],
			[['infill_every_layers'], 'integer', 'min'=>1],
			[['solid_infill_every_layers', 'solid_infill_below_area', 'fill_angle', 'infill_first'], 'integer'],
			[['perimeter_speed', 'infill_speed', 'support_material_speed', 'bridge_speed', 'gap_fill_speed', 'travel_speed','perimeter_acceleration', 'infill_acceleration', 'bridge_acceleration', 'first_layer_acceleration', 'default_acceleration'], 'integer'],
			[['skirt_distance', 'skirts', 'skirt_height', 'min_skirt_length', 'brim_width'], 'integer'],
			[['support_material_threshold','support_material','support_material_enforce_layers', 'raft_layers', 'support_material_angle', 'support_material_interface_layers', 'support_material_interface_spacing', 'dont_support_bridges'], 'integer'],
			[['support_material_pattern'], 'string'],
			[['fill_density', 'small_perimeter_speed', 'external_perimeter_speed', 'solid_infill_speed', 'top_solid_infill_speed', 'support_material_interface_speed', 'first_layer_speed'], 'match', 'pattern' =>'/^\s?[0-9]*\.?[0-9]+?%?\s*$/'],
			[['extrusion_width', 'first_layer_extrusion_width', 'perimeter_extrusion_width', 'solid_infill_extrusion_width', 'top_infill_extrusion_width', 'infill_extrusion_width', 'support_material_extrusion_width'], 'match', 'pattern'=>'/^\s?[0-9]*\.?[0-9]+?%?\s*$/'],
			[['bridge_flow_ratio','resolution','threads'], 'integer'],
			[['extrusion_multiplier', 'filament_diameter'], 'number'],
			[[ 'first_layer_temperature', 'temperature', 'first_layer_bed_temperature', 'bed_temperature'], 'integer'],
			[['fan_always_on', 'cooling', 'min_fan_speed', 'max_fan_speed', 'bridge_fan_speed'], 'integer', 'max'=>100, 'min'=>0],
			[['disable_fan_first_layers', 'fan_below_layer_time', 'slowdown_below_layer_time', 'min_print_speed', 'vibration_limit'], 'integer'],
			//[['min_fan_speed'], 'compare', 'compareAttribute'=>$this->max_fan_speed, 'compareValue'=> $this->max_fan_speed, 'operator' => '<'],
			[['bed_size_x', 'bed_size_y', 'print_center_x', 'print_center_y', 'use_relative_e_distances', 'use_firmware_retraction'], 'integer', 'min'=>0],
			[['z_offset'], 'number'],
			[['gcode_flavor'], 'string'],
			[['start_gcode', 'end_gcode','layer_gcode', 'toolchange_gcode'], 'string'],
			[['nozzle_diameter', 'retract_length', 'retract_lift', 'retract_speed', 'retract_restart_extra', 'retract_before_travel', 'retract_layer_change', 'wipe'],'number'],
        ];
    }
	

    public function attributeLabels()
    {
        return [
           'layer_height'=> Yii::t('slic3r', 'Layer Height'),
		   'first_layer_height'=> Yii::t('slic3r', 'First Layer Height'),
		   'perimeters'=> Yii::t('slic3r', 'Permeters (minimum)'),
		   'spiral_vase'=> Yii::t('slic3r', 'Spiral Vase'),
		   'top_solid_layers'=> Yii::t('slic3r', 'Top Solid Layers'),
		   'bottom_solid_layers'=> Yii::t('slic3r', 'Bottom Solid Layers'),
		   'extra_perimeters'=> Yii::t('slic3r', 'Extra Perimeters'),
		   'avoid_crossing_perimeters'=> Yii::t('slic3r', 'Avoid Crossing Perimeters (slow)'),
		   'thin_walls'=> Yii::t('slic3r', 'Detect Thin Walls'),
		   'overhangs' => Yii::t('slic3r', 'Detect Bridgeing Permeters'),
		   'bed_size_x'=>Yii::t('slic3r', 'Bed Size - X Axis'),
		   'bed_size_y'=>Yii::t('slic3r', 'Bed Size - Y Axis'),
		   'print_center_x'=>Yii::t('slic3r', 'Print Center - X Axis'),
		   'print_center_y'=>Yii::t('slic3r', 'Print Center - Y Axis'),
			'bed_size'=>Yii::t('slic3r', 'Bed Size'),
			'bed_temperature'=>Yii::t('slic3r', 'Other Layers'),
			'bridge_acceleration'=>Yii::t('slic3r', 'Bridge'),
			'bridge_fan_speed'=>Yii::t('slic3r', 'Bridge Fan'),
			'bridge_flow_ratio'=>Yii::t('slic3r', 'Bridge Flow Ratio'),
			'bridge_speed'=>Yii::t('slic3r', 'Bridge'),
			'brim_width'=>Yii::t('slic3r', 'Brim Width'),
			'complete_objects'=>Yii::t('slic3r', 'Complete Objects'),
			'cooling'=>Yii::t('slic3r', 'Enable Auto Cooling'),
			'default_acceleration'=>Yii::t('slic3r', 'Default'),
			'disable_fan_first_layers'=>Yii::t('slic3r', 'Disable Fan For The First'),
			'dont_support_bridges'=>Yii::t('slic3r', 'Don\'t Support Bridges'),
			'duplicate_distance'=>Yii::t('slic3r', 'duplicate_distance'),
			'end_gcode'=>Yii::t('slic3r', 'End GCode'),
			'external_perimeter_speed'=>Yii::t('slic3r', 'External Perimeter'),
			'external_perimeters_first'=>Yii::t('slic3r', 'External Perimeters First'),
			'extruder_clearance_height'=>Yii::t('slic3r', 'extruder_clearance_height'),
			'extruder_clearance_radius'=>Yii::t('slic3r', 'extruder_clearance_radius'),
			'extruder_offset'=>Yii::t('slic3r', 'Extruder Offset'),
			'extrusion_axis'=>Yii::t('slic3r', 'Extrusion Axis'),
			'extrusion_multiplier'=>Yii::t('slic3r', 'Extrusion Multiplier'),
			'extrusion_width'=>Yii::t('slic3r', 'Extrusion Width'),
			'fan_always_on'=>Yii::t('slic3r', 'Keep Fan Always On'),
			'fan_below_layer_time'=>Yii::t('slic3r', 'Enable Fan If Layers Print Time is Below'),
			'filament_diameter'=>Yii::t('slic3r', 'Filament Diameter'), 
			'fill_angle'=>Yii::t('slic3r', 'Fill Angle'),
			'fill_density'=>Yii::t('slic3r', 'Fill Density'),
			'fill_pattern'=>Yii::t('slic3r', 'Fill Pattern'),
			'first_layer_acceleration'=>Yii::t('slic3r', 'First Layer'),
			'first_layer_bed_temperature'=>Yii::t('slic3r', 'First Layer'),
			'first_layer_extrusion_width'=>Yii::t('slic3r', 'First Layer'),
			'first_layer_speed'=>Yii::t('slic3r', 'First Layer'),
			'first_layer_temperature'=>Yii::t('slic3r', 'First Layer'),
			'g0'=>Yii::t('slic3r', 'g0'),
			'gap_fill_speed'=>Yii::t('slic3r', 'Gap Fill'),
			'gcode_arcs'=>Yii::t('slic3r', 'gcode_arcs'),
			'gcode_comments'=>Yii::t('slic3r', 'gcode_comments'),
			'gcode_flavor'=>Yii::t('slic3r', 'G-code Flavor'),
			'infill_acceleration'=>Yii::t('slic3r', 'Infill'),
			'infill_every_layers'=>Yii::t('slic3r', 'Combine Infill Every'),
			'infill_extruder'=>Yii::t('slic3r', 'infill_extruder'),
			'infill_extrusion_width'=>Yii::t('slic3r', 'Infill'),
			'infill_first'=>Yii::t('slic3r', 'Infill Before Permeters'),
			'infill_only_where_needed'=>Yii::t('slic3r', 'Only Infill Where Needed'),
			'infill_speed'=>Yii::t('slic3r', 'Infill'),
			'interface_shells'=>Yii::t('slic3r', 'interface_shells'),
			'layer_gcode'=>Yii::t('slic3r', 'layer_gcode'),
			'max_fan_speed'=>Yii::t('slic3r', 'Max Fan Speed'),
			'min_fan_speed'=>Yii::t('slic3r', 'Min Fan Speed'),
			'min_print_speed'=>Yii::t('slic3r', 'Min Print Speed'),
			'min_skirt_length'=>Yii::t('slic3r', 'Minimum Extrusion Length'),
			'notes'=>Yii::t('slic3r', 'notes'),
			'nozzle_diameter'=>Yii::t('slic3r', 'Nozzle Diameter'),
			'only_retract_when_crossing_perimeters'=>Yii::t('slic3r', 'Only Retract When Crossing'),
			'ooze_prevention'=>Yii::t('slic3r', 'ooze_prevention'),
			'output_filename_format'=>Yii::t('slic3r', 'output_filename_format'),
			'perimeter_acceleration'=>Yii::t('slic3r', 'Perimeter'),
			'perimeter_extruder'=>Yii::t('slic3r', 'perimeter_extruder'),
			'perimeter_extrusion_width'=>Yii::t('slic3r', 'Perimeter'),
			'perimeter_speed'=>Yii::t('slic3r', 'Perimeter'),
			'post_process'=>Yii::t('slic3r', 'post_process'),
			'print_center'=>Yii::t('slic3r', 'print_center'),
			'raft_layers'=>Yii::t('slic3r', 'Raft Layers'),
			'resolution'=>Yii::t('slic3r', 'Resolution'),
			'retract_before_travel'=>Yii::t('slic3r', 'Min Travel After Retraction'),
			'retract_layer_change'=>Yii::t('slic3r', 'Retract On Layer Change'),
			'retract_length'=>Yii::t('slic3r', 'Length'),
			'retract_length_toolchange'=>Yii::t('slic3r', 'retract_length_toolchange'),
			'retract_lift'=>Yii::t('slic3r', 'Lift Z'),
			'retract_restart_extra'=>Yii::t('slic3r', 'Extra Length On Restart'),
			'retract_restart_extra_toolchange'=>Yii::t('slic3r', 'retract_restart_extra_toolchange'),
			'retract_speed'=>Yii::t('slic3r', 'Speed'),
			'seam_position'=>Yii::t('slic3r', 'Seam Position'),
			'skirt_distance'=>Yii::t('slic3r', 'Distance from Object'),
			'skirt_height'=>Yii::t('slic3r', 'Skirt Height'),
			'skirts'=>Yii::t('slic3r', 'Loops'),
			'slowdown_below_layer_time'=>Yii::t('slic3r', 'Slow Down If Layer Print Time is Below'),
			'small_perimeter_speed'=>Yii::t('slic3r', 'Small Perimeter'),
			'solid_fill_pattern'=>Yii::t('slic3r', 'Top/Bottom Fill Pattern'),
			'solid_infill_below_area'=>Yii::t('slic3r', 'Solid Infill Threshold Area'),
			'solid_infill_every_layers'=>Yii::t('slic3r', 'Solid Infill Every'),
			'solid_infill_extrusion_width'=>Yii::t('slic3r', 'Solid Infill'),
			'solid_infill_speed'=>Yii::t('slic3r', 'Solid Infill'),
			'standby_temperature_delta'=>Yii::t('slic3r', 'standby_temperature_delta'),
			'start_gcode'=>Yii::t('slic3r', 'Start Gcode'),
			'support_material'=>Yii::t('slic3r', 'Generate Support Material'),
			'support_material_angle'=>Yii::t('slic3r', 'Pattern Angle'),
			'support_material_enforce_layers'=>Yii::t('slic3r', 'Enforce Support For The First'),
			'support_material_extruder'=>Yii::t('slic3r', 'support_material_extruder'),
			'support_material_extrusion_width'=>Yii::t('slic3r', 'Support Material'),
			'support_material_interface_extruder'=>Yii::t('slic3r', 'support_material_interface_extruder'),
			'support_material_interface_layers'=>Yii::t('slic3r', 'Interface Layers'),
			'support_material_interface_spacing'=>Yii::t('slic3r', 'Interface Pattern Spacing'),
			'support_material_interface_speed'=>Yii::t('slic3r', 'Support Material Interface'),
			'support_material_pattern'=>Yii::t('slic3r', 'Pattern'),
			'support_material_spacing'=>Yii::t('slic3r', 'Pattern Spacing'),
			'support_material_speed'=>Yii::t('slic3r', 'Support Material Speed'),
			'support_material_threshold'=>Yii::t('slic3r', 'Overhang Threshold'),
			'temperature'=>Yii::t('slic3r', 'Other Layers'),
			'threads'=>Yii::t('slic3r', 'Threads'),
			'toolchange_gcode'=>Yii::t('slic3r', 'toolchange_gcode'),
			'top_infill_extrusion_width'=>Yii::t('slic3r', 'Top Infill'),
			'top_solid_infill_speed'=>Yii::t('slic3r', 'Top Solid Infill'),
			'travel_speed'=>Yii::t('slic3r', 'Travel'),
			'use_firmware_retraction'=>Yii::t('slic3r', 'Use Firmware Retraction'),
			'use_relative_e_distances'=>Yii::t('slic3r', 'Use Relative E Distances'),
			'vibration_limit'=>Yii::t('slic3r', 'Vibration Limit'),
			'wipe'=>Yii::t('slic3r', 'Wipe While Retracting'),
			'z_offset'=>Yii::t('slic3r', 'Z Offset'), 
        ];
    }
	
	public function initialConfig($config_lite_object_array)
	{
		/*
		foreach($config_lite_object_array as $key=>$value)
		{
			echo $key;
			echo '<br/>';
		}
		*/
		foreach($config_lite_object_array as $key=>$value)
		{
			
			if($key == 'bed_size' or $key == 'print_center')
			{
				//replace all space in the value
				$value = preg_replace('/\s+/', '', $value);
				// separe the string by ","
				$value_array = explode(',', $value);

				$key_x = $key.'_x';
				$key_y = $key.'_y';
				$this->$key_x = $value_array[0];
				$this->$key_y = $value_array[1];
				
			} else if($key == 'start_gcode' or $key =='end_gcode' or $key == 'layer_gcode' or $key == 'toolchange_gcode') {
				
				//$value = nl2br($value);
				$value = str_replace('\n', '&#10;', trim($value));
				$this->$key = $value;
				
			} else {
				$this->$key = $value;
			}
			/*
			if(substr($value, -1) == '%')
			{
				$value_get = substr($value, 0, -1);
				$value_new = (int)$value_get;
				$this->$key = $value_new;
			} else {
				$this->$key = $value;
			}
			*/
		}
	}
	
	public function beforeSave()
	{
		$replace_new_line = array("\r\n", "&#10;");
		
		//modify for the textarea
		$this->start_gcode = str_replace($replace_new_line, "\\n", $this->start_gcode);
		$this->end_gcode = str_replace($replace_new_line, "\\n", $this->end_gcode);
		$this->layer_gcode = str_replace($replace_new_line, "\\n", $this->layer_gcode);
		$this->toolchange_gcode = str_replace($replace_new_line, "\\n", $this->toolchange_gcode);
		
		
		$this->bed_size = trim($this->bed_size_x).','.trim($this->bed_size_y);
		$this->print_center = trim($this->print_center_x).','.trim($this->print_center_y);
		
		
		// modify for the fill_density
		$this->fill_density = trim($this->fill_density);
		
		if(substr($this->fill_density, '-1') != '%')
		{
			if(floatval($this->fill_density) > 100)
				$this->fill_density = 100;	
		} else {
			$value = substr($this->fill_density, 0 , -1);
			if(floatval($value) > 100)
				$this->fill_density = 100;
			else
				$this->fill_density = substr($this->fill_density, 0 , -1);
		}
		
		$this->fill_density = $this->fill_density.'%';

	}
	
	public function save()
	{
		if ($this->validate()) {
			
			$this->beforeSave();
			
			$ConfigFile = new ConfigFile();
			$Config = $ConfigFile->readConfigFile();
			
			foreach($this->getAttributes() as $key=>$value)
			{
				$value = trim($value);
				$Config->set(null, $key, $value);
			}
			$Config->save();
        } else {
            return false;
        }
	}
	
}
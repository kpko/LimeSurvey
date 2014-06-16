<script type="text/javascript">
    var sMsgMaximumExcelColumns = '<?php $clang->eT("You can only choose 255 colums at a maximum for Excel export.",'js'); ?>';
    var sMsgExcelColumnsReduced = '<?php $clang->eT("The number of selected columns was reduced automatically.",'js'); ?>';
    var sMsgColumnCount = '<?php $clang->eT("%s of %s columns selected",'js'); ?>';
</script>
<div class='header ui-widget-header'><?php $clang->eT("Export results");?>
    <?php     if (isset($_POST['sql'])) {echo" - ".$clang->gT("Filtered from statistics script");}
        if ($SingleResponse) {
            echo " - ".sprintf($clang->gT("Single response: ID %s"),$SingleResponse);} 
    ?>
</div>
<div class='wrap2columns'>
    <?php echo CHtml::form(array('admin/export/sa/exportresults/surveyid/'.$surveyid), 'post', array('id'=>'resultexport'));?>
        <div class='left'>
<fieldset><legend><?php $clang->eT("Format");?></legend>
                <ul>  
<?php
    $hasTips = false;
    foreach ($exports as $key => $info)
    {
        // Only output when a label was set
        if (!empty($info['label'])) {
            $htmlOptions = array(
                'id'=>$key,
                'value'=>$key,
                'class'=>'radiobtn'
                );
            // For onclick, always start to re-enable all disabled elements
            $htmlOptions['onclick'] = "$('form#resultexport input:disabled').attr('disabled', false);" . $info['onclick'];
            if (!empty($info['tooltip'])) {
                $hasTips = true;
                $tooltip = CHtml::openTag('div', array('class'=>'tooltip-export'));
                $tooltip .= CHtml::image($imageurl. '/help.gif');
                $tooltip .= ChTml::tag('div', array('class'=>'exporttip'), $info['tooltip']);
                $tooltip .= CHtml::closeTag('div');
            } else {
                $tooltip = '';
            }
            echo CHtml::openTag('li');
            echo CHtml::radioButton('type', $info['checked'], $htmlOptions);
            echo " "; // Needed to get space between radio element and label
            echo CHtml::label($info['label'], $key);
            echo $tooltip;
            echo CHtml::closeTag('li');
        }
    }
    if ($hasTips) {
        // We have tooltips, now register javascript
        App()->clientScript->registerScript('tooltip-export', 
                "jQuery('div.tooltip-export').popover({
                    html: true,
                    content: function() {
                        return $(this).find('div.exporttip').clone();
                    },
                    title: function() { 
                        return $(this).parent().find('label').text();
                    },
                    trigger: 'hover'
                });
                ");
    }
?>
            </ul></fieldset>            
            <fieldset <?php  if ($SingleResponse) {?>
                style='display:none';
            <?php } ?>
            ><legend><?php $clang->eT("General");?></legend>

                <ul><li><?php $clang->eT("Range:");?><br>
                        <?php echo CHTML::label(gT("From"),"export_from") . CHTML::numberField('export_from','1',array('min'=>1,'max'=>$max_datasets,'step'=>1,'style'=>'max-width:7em')) ?>
                        <?php echo CHTML::label(gT("to"),"export_to") . CHTML::numberField('export_to',$max_datasets,array('min'=>1,'max'=>$max_datasets,'step'=>1,'style'=>'max-width:7em')) ?>
                    </li>

                    <li><label for='completionstate'><?php $clang->eT("Completion state");?></label> <select id='completionstate' name='completionstate'>
                            <option value='complete' <?php echo $selecthide;?>><?php $clang->eT("Completed responses only");?></option>
                            <option value='all' <?php echo $selectshow;?>><?php $clang->eT("All responses");?></option>
                            <option value='incomplete' <?php echo $selectinc;?>><?php $clang->eT("Incomplete responses only");?></option>
                        </select>
                    </li>
                        <?php echo CHTML::label(gT("Export language"),"exportlang");
                            echo CHtml::dropDownList('exportlang', null, $aLanguages);
                        ?>
                    </ul></fieldset>

            <fieldset><legend>
                <?php $clang->eT("Headings");?></legend>
                <ul>
                    <?php foreach($headexports as $type=>$label)
                    {
                        $content = CHTML::radioButton('headstyle',$selectedheadexports==$type,array('value'=>$type,'id'=>"headstyle-{$type}"))
                                 . CHTML::label($label,"headstyle-{$type}");
                        echo CHTML::tag('li',array(),$content);
                    }
                    ?>
                        <!--<fieldset>
                            <legend><?php $clang->eT("Heading option");?></legend>-->
                            <ul>
                                <li><?php echo CHTML::checkBox('headspacetounderscores',false,array('value'=>'1','id'=>'headspacetounderscores'));
                                    echo CHTML::label($clang->gT("Convert spaces in question text to underscores"),'headspacetounderscores'); ?></li>
                                <li><?php echo CHTML::checkBox('abbreviatedtext',false,array('value'=>'1','id'=>'abbreviatedtext'));
                                    echo CHTML::label($clang->gT("Text abbreviated"),'abbreviatedtext');?>
                                    <ul>
                                    <li><?php echo CHTML::label($clang->gT("Number of caracters"),'abbreviatedtextto');
                                    echo CHTML::numberField('abbreviatedtextto','15',array('id'=>'abbreviatedtextto','size'=>'4','min'=>'1','step'=>'1')); ?></li>
                                    </ul>
                                </li>
                                <li><?php echo CHTML::checkBox('emcode',false,array('value'=>'emcode','id'=>'emcode'));
                                    echo CHTML::label($clang->gT("Use expression manager code"),'emcode'); ?></li>
                                <li><?php echo CHTML::label($clang->gT("Code an texte separator"),'codetextseparator');
                                echo CHTML::textField('codetextseparator','. ',array('id'=>'codetextseparator','size'=>'4')); ?></li>
                            </ul>
                        <!--</fieldset>-->
                    </li>
                </ul>
                <ul>
                
                </ul>
            </fieldset>

            <fieldset>
                <legend><?php $clang->eT("Responses");?></legend>
                <ul>
                    <li><?php echo CHTML::radioButton('answers',false,array('value'=>'short','id'=>'answers-short'));
                        echo CHTML::label($clang->gT("Answer codes"),'answers-short');?>
                        <ul>
                            <li><?php echo CHTML::checkBox('converty',false,array('value'=>'Y','id'=>'converty'));
                                echo CHTML::label($clang->gT("Convert Y to"),'converty');?>
                                <?php echo CHTML::textField('convertyto','1',array('id'=>'convertyto','size'=>'3','maxlength'=>'1')); ?>
                            </li>
                            <li><?php echo CHTML::checkBox('convertn',false,array('value'=>'Y','id'=>'convertn'));
                                echo CHTML::label($clang->gT("Convert N to"),'convertn');?>
                                <?php echo CHTML::textField('convertnto','2',array('id'=>'convertnto','size'=>'3','maxlength'=>'1')); ?>
                            </li>
                        </ul>
                    </li>
                    <li><?php echo CHTML::radioButton('answers',true,array('value'=>'long','id'=>'answers-long'));
                        echo CHTML::label($clang->gT("Full answers"),'answers-long');?>
                </ul></fieldset>
        </div>
        <div class='right'>
            <fieldset>
                <legend><?php $clang->eT("Column control");?></legend>

                <input type='hidden' name='sid' value='<?php echo $surveyid; ?>' />
                <?php 
                    if ($SingleResponse) { ?>
                    <input type='hidden' name='response_id' value="<?php echo $SingleResponse;?>" />
                    <?php }
                    $clang->eT("Choose columns");?>:
                <br />
                <?php 
                echo CHtml::listBox('colselect[]',array_keys($aFields),$aFields,array('multiple'=>'multiple','size'=>'20','style'=>'width:370px;'));
                echo "\t<img src='$imageurl/help.gif' alt='".$clang->gT("Help")."' onclick='javascript:alert(\"".$clang->gT("Please note: The export to Excel is currently limited to loading no more than 255 columns.","js")."\")'>";?>
                <span id='columncount'>&nbsp;</span>
                </fieldset>
            <?php if ($thissurvey['anonymized'] == "N" && tableExists("{{tokens_$surveyid}}") && Permission::model()->hasSurveyPermission($surveyid,'tokens','read')) { ?>
                <fieldset><legend><?php $clang->eT("Token control");?></legend>
                    <?php $clang->eT("Choose token fields");?>:
                    <img src='<?php echo $imageurl;?>/help.gif' alt='<?php $clang->eT("Help");?>' onclick='javascript:alert("<?php $clang->gT("Your survey can export associated token data with each response. Select any additional fields you would like to export.","js");?>")' /><br />
                    <select name='attribute_select[]' multiple size='20'>
                        <option value='first_name' id='first_name'><?php $clang->eT("First name");?></option>
                        <option value='last_name' id='last_name'><?php $clang->eT("Last name");?></option>
                        <option value='email_address' id='email_address'><?php $clang->eT("Email address");?></option>

                        <?php $attrfieldnames=getTokenFieldsAndNames($surveyid,true);
                            foreach ($attrfieldnames as $attr_name=>$attr_desc)
                            {
                                echo "<option value='$attr_name' id='$attr_name' />".$attr_desc['description']."</option>\n";
                        } ?>
                    </select></fieldset>
                <?php } ?>
        </div>
        <div style='clear:both;'><p><input type='submit' value='<?php $clang->eT("Export data");?>' /></div></form></div>

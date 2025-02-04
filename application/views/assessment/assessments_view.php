<?php
/**
* Assesments view
*/

// todo implement new ekeditor 1580136051118
//echo PrepareEditorScript(true, $this);

$pageSize = intval(Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']));

?>
  <div class="side-body <?=getSideBodyClass(false)?>">
    <?=viewHelper::getViewTestTag('surveyAssessments');?>
      <h3 class="page-title"><?=gT("Assessments")?></h3>
        <?php
            $messageLink = gT("Assessment mode for this survey is not activated.").'<br/>'
                . gT("If you want to activate it, click here:").'<br/>'
                . '<a type="submit" class="btn btn-primary" href="'
                . $this->createUrl('/assessment/activate', ['surveyid'=> $surveyid])
                .'">'.gT('Activate assessements').'</a>';
        if(!Assessment::isAssessmentActive($surveyid)) {
        ?>
          <div class="row text-center">
            <div class="jumbotron message-box warningheader col-sm-12 col-md-6 col-md-offset-3">
              <h2><?= gT("Assessment mode not activated"); ?></h2>
              <?php echo $messageLink; ?>
            </div>
          </div>

        <?php
        } else {
        ?>
            <h4><?php eT("Assessment rules");?></h4>
            <div class="row">
                <a href="#" id="loadEditUrl_forModalView" data-editurl="<?=$this->createUrl("assessment/edit/", ["surveyid" => $surveyid]);?>"></a>
                <?php
                    $this->widget('ext.LimeGridView.LimeGridView', array(
                        'dataProvider' => $model->search(),
                        'id' => 'assessments-grid',
                        'columns' => $model->getColumns(),
                        'filter' => $model,
                        'emptyText'=>gT('No customizable entries found.'),
                        'summaryText'=>gT('Displaying {start}-{end} of {count} result(s).').' '
                        . sprintf(gT('%s rows per page'),
                            CHtml::dropDownList(
                                'pageSize',
                                $pageSize,
                                Yii::app()->params['pageSizeOptions'],
                                array('class'=>'changePageSize form-control', 'style'=>'display: inline; width: auto')
                            )
                        ),
                        'rowHtmlOptionsExpression' => '["data-assessment-id" => $data->id]',
                        'htmlOptions'              => ['class' => 'table-responsive'],
                        'ajaxType'                 => 'POST',
                        'ajaxUpdate'               => 'assessments-grid',
                        'template'                 => "{items}\n<div id='tokenListPager'><div class=\"col-sm-4\" id=\"massive-action-container\"></div><div class=\"col-sm-4 pager-container ls-ba \">{pager}</div><div class=\"col-sm-4 summary-container\">{summary}</div></div>",
                        'afterAjaxUpdate'          => 'bindAction',
                    ));
                ?>
            </div>
            <?php if ( Permission::model()->hasSurveyPermission($surveyid, 'assessments', 'create') ) { ?>
              <div class="row">
                <div class="col-sm-12">
                  <button class="btn btn-success" id="selector__assessment-add-new">
                    <?=eT("Add new assessment rule")?>
                  </button>
                </div>
              </div>
            <?php } ?>
            <!-- Edition - Modal -->
            <?php if ((Permission::model()->hasSurveyPermission($surveyid, 'assessments','update'))  || (Permission::model()->hasSurveyPermission($surveyid, 'assessments','create')) ) { ?>
                <?php $this->renderPartial('assessments_delete', ['surveyid' => $surveyid]); ?>
                <?php 
                    $this->renderPartial('assessments_edit', [
                            'surveyid' => $surveyid,
                            'editId' => $editId,
                            'assessmentlangs' => $assessmentlangs,
                            'baselang' => $baselang,
                            'groups' => isset($groups) ? $groups : [],
                            'gid' => $groupId,
                        ]
                    );
                ?>
            <?php } ?>
  <!-- opened in controller -->
    <?php 
    };
    ?>
</div>

<script type="text/javascript">
jQuery(function($) {
    // To update rows per page via ajax
    $(document).on("change", '#pageSize', function() {
        $.fn.yiiGridView.update('assessments-grid', {data:{pageSize: $(this).val()}});
    });
});
</script>

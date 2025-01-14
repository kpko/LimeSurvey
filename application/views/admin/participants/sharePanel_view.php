<?php
/**
 * @var AdminController $this
 * @var ParticipantShare $model
 * @var string $massiveAction
 * @var int $pageSizeShareParticipantView
 */

// DO NOT REMOVE This is for automated testing to validate we see that page
echo viewHelper::getViewTestTag('participantsSharePanel');

?>
<div id="pjax-content">
    <div class="col-lg-12 list-surveys">
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $this->widget(
                        'bootstrap.widgets.TbGridView',
                        [
                            'id'                       => 'share_central_participants',
                            'emptyText'                => gT('No shared participants found'),
                            'htmlOptions'              => ['class' => 'table-responsive'],
                            'dataProvider'             => $model->search(),
                            'rowHtmlOptionsExpression' => '["data-participant_id" => $data->participant_id, "data-share_uid" => $data->share_uid]',
                            'columns'                  => $model->columns,
                            'filter'                   => $model,
                            'ajaxType'                 => 'POST',
                            'afterAjaxUpdate'          => 'LS.CPDB.bindButtons',
                            'template'                 => "{items}\n<div id='tokenListPager'><div class=\"col-sm-4\" id=\"massive-action-container\">$massiveAction</div><div class=\"col-sm-4 pager-container ls-ba \">{pager}</div><div class=\"col-sm-4 summary-container\">{summary}</div></div>",
                            'summaryText'              => gT('Displaying {start}-{end} of {count} result(s).') . ' ' . sprintf(
                                gT('%s rows per page'),
                                CHtml::dropDownList(
                                    'pageSizeShareParticipantView',
                                    $pageSizeShareParticipantView,
                                    Yii::app()->params['pageSizeOptions'],
                                    ['class' => 'changePageSize form-control', 'style' => 'display: inline; width: auto']
                                )
                            ),
                        ]
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
    <span id="locator" data-location="sharepanel">&nbsp;</span>
</div>

<?php
?>
<?php
    /**
     * This is the view, when your are trying to delete the survey participants table.
     */
?>
<div class='side-body <?php echo getSideBodyClass(false); ?>'>
    <div class="row welcome survey-action">
        <div class="col-sm-12 content-right">
            <div class="jumbotron message-box message-box-error">
                <h3 style="border-bottom: solid 2px #a15426;">
                    <p class="lead text-warning">
                        <strong>
                            <?php eT("Delete survey participants table"); ?>
                        </strong>
                    </p>
                </h3>
                <p style="margin-top: 50px;">
                    <?php 
                    eT("The participant table has now been removed and your survey switched back to "); 
                    ?>
                    <strong>
                        <?php eT("open-access mode."); ?>
                    </strong>
                    <br> 
                    <br>
                    <?php eT("Access codes are no longer required to access this survey.");?>
                    <br>
                    <br>
                    <?php eT("A backup of this table has been made and can be accessed by your administrator.");?>
                    <br>
                    <?php echo '("' . $tableName  . '")'?>
                    <br>
                    <br>
                    <?php eT("If you want to switch back to closed-access mode you only need to initialise the participants table again "); ?>
                    <br>
                    <?php eT("for this survey."); ?>
                    <br>
                    <br>
                </p>
                <?php echo CHtml::form(array("admin/tokens/sa/kill/surveyid/{$iSurveyId}"), 'post'); ?>
                    <button class="btn btn-default btn-lg" type="submit" name="cancel" href="<?php echo $this->createUrl("surveyAdministration/view/surveyid/" . $iSurveyId) ?>">
                        <?php eT("Back to main admin screen") ?>
                    </button>
                <?php echo CHtml::endForm() ?>
            </div>
        </div>
    </div>
</div>

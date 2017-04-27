<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $formTitle,
    'headerIcon' => $formIcon,
));
if ($items['controllers'] !== array()) {
    ?>
    <table class="action-table table table-striped">
        <thead>
            <tr>
                <th></th>
                <th><?php echo Rights::t('core', 'Action'); ?></th>
                <th><?php echo Rights::t('core', 'Location'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($items['controllers'] as $key => $item) {
                if (isset($item['actions']) && $item['actions'] !== array()) {
                    $controllerKey = isset($moduleName) ? ucfirst($moduleName) . '.' . ucfirst($item['name']) : ucfirst($item['name']);
                    $controllerExists = isset($existingItems[$controllerKey . '.*']);
                    $allActionsCreated = true;
                    foreach ($item['actions'] as $action) {
                        $actionKey = $controllerKey . '.' . ucfirst($action['name']);
                        if (!isset($existingItems[$actionKey]))
                            $allActionsCreated = false;
                    }
                    ?>
                    <tr class="controller-row success">
                        <td class="checkbox-column"><?php echo!$controllerExists ? $form->checkBox($model, 'items[' . $controllerKey . '.*]') : ''; ?></td>
                        <td class="name-column"><span class="label <?php echo $controllerExists && $allActionsCreated ? 'label-warning' : 'label-success' ?>"><?php echo ucfirst($item['name']) . '.*'; ?></span></td>
                        <td class="path-column"><?php echo substr($item['path'], $basePathLength + 1); ?></td>
                    </tr>
                    <?php
                    $i = 0;
                    foreach ($item['actions'] as $action) {
                        $actionKey = $controllerKey . '.' . ucfirst($action['name']);
                        $actionExists = isset($existingItems[$actionKey]);
                        ?>
                        <tr class="action-row<?php echo $actionExists ? ' warning' : ''; ?><?php echo ($i++ % 2) === 0 ? ' odd' : ' even'; ?>">
                            <td class="checkbox-column"><?php echo!$actionExists ? $form->checkBox($model, 'items[' . $actionKey . ']') : ''; ?></td>
                            <td class="name-column"><?php echo $action['name']; ?></td>
                            <td class="path-column"><?php echo substr($item['path'], $basePathLength + 1) . (isset($action['line']) ? ':' . $action['line'] : ''); ?></td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
        </tbody>
    </table>
    <?php
} else {
    Yii::app()->user->setFlash('info', 'No action found.');
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => '×'), 
        ),
    ));
}
$this->endWidget();
// Modules
if ($items['modules'] !== array()) {
    foreach ($items['modules'] as $moduleName => $moduleItems) {
        if ($moduleName != 'rights') {
            $this->renderPartial('_generateItems', array(
                'formTitle' => ucfirst($moduleName) . ' ' . Rights::t('core', 'Module'),
                'formIcon' => 'fa fa-gift',
                'model' => $model,
                'form' => $form,
                'items' => $moduleItems,
                'existingItems' => $existingItems,
                'moduleName' => $moduleName,
                'basePathLength' => $basePathLength,
            ));
        }
    }
}
?>
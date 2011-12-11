<?
  function render_purchase_personal_data_input($field, $required = FALSE) {
    echo '<div class="clearfix input '. (( ! $field->error()) ? 'correct' : 'error') .'">
            <div class="lab help">
              <label for="' . $field->alias() . '">' . $field->get('label') . ' ' . (($required) ? ('<span>*</span>') : '') . '</label><em></em>
          </div>
          <div class="con">' . $field->render() . '</div>
        </div>';
  }
  
?>

<?=$form->open()?>
  <?if ($errors = $form->errors()):?>
    <?foreach ($errors as $error):?>
      <?=$error?><br />
    <?endforeach;?>
  <?endif;?>

  <fieldset>
    <div class="cols cols3">
      <div class="col1">
        <?=render_purchase_personal_data_input($form->name, TRUE)?>
      </div>
      
      <div class="col2">
        <?=render_purchase_personal_data_input($form->surname, TRUE)?>
      </div>
    </div>
    
    <div class="cols cols3">
      <div class="col1">
        <?=render_purchase_personal_data_input($form->street, TRUE)?>
      </div>
      
      <div class="col2">
        <?=render_purchase_personal_data_input($form->city, TRUE)?>
      </div>
      
      <div class="col3">
        <?=render_purchase_personal_data_input($form->postcode, TRUE)?>
      </div>
    </div>
    
    <div class="cols cols3">
      <div class="col1">
        <?=render_purchase_personal_data_input($form->email, TRUE)?>
      </div>
      
      <div class="col2">
        <?=render_purchase_personal_data_input($form->phone, TRUE)?>
      </div>
    </div>
    
    <?=$form->company_data->view()->attr(array ('id' => $form->company_data->name()))->field()->render()?> <label for="<?=$form->company_data->name()?>"><?=$form->company_data->get('label')?></label>
    
    <div class="cols cols3">
      <div class="col1">
        <?=render_purchase_personal_data_input($form->company, TRUE)?>
      </div>
      
      <div class="col2">
        <?=render_purchase_personal_data_input($form->cin)?>
      </div>
      
      <div class="col3">
        <?=render_purchase_personal_data_input($form->tin)?>
      </div>
    </div>
    
    <?=$form->delivery_address->view()->attr(array ('id' => $form->delivery_address->name()))->field()->render()?> <label for="<?=$form->delivery_address->name()?>"><?=$form->delivery_address->get('label')?></label>
    
    <div class="cols cols3">
      <div class="col1">
        <?=render_purchase_personal_data_input($form->delivery_company)?>
      </div>
      
      <div class="col2">
        <?=render_purchase_personal_data_input($form->delivery_name, TRUE)?>
      </div>
      
      <div class="col3">
        <?=render_purchase_personal_data_input($form->delivery_surname, TRUE)?>
      </div>
    </div>
    
    <div class="cols cols3">
      <div class="col1">
        <?=render_purchase_personal_data_input($form->delivery_street, TRUE)?>
      </div>
      
      <div class="col2">
        <?=render_purchase_personal_data_input($form->delivery_city, TRUE)?>
      </div>
      
      <div class="col3">
        <?=render_purchase_personal_data_input($form->delivery_postcode, TRUE)?>
      </div>
    </div>
    
    <div class="cols cols3">
      <div class="col1">
        <?=render_purchase_personal_data_input($form->delivery_phone)?>
      </div>
    </div>
    
    <?if (isset($data['signup_newsletter_enabled'])):?>
      <div>
        <?=$form->signup_newsletter->view()->attr(array ('id' => $form->signup_newsletter->name()))->field()->render()?> <label for="<?=$form->signup_newsletter->name()?>"><?=$form->signup_newsletter->get('label')?></label>
      </div>
    <?endif;?>
    
    <div>
      <?=$form->license_terms->view()->attr(array ('id' => $form->license_terms->name()))->field()->render()?> <label for="<?=$form->license_terms->name()?>"><?=$form->license_terms->get('label')?></label>
    </div>
    
    <input type="submit" value="Pokračovat" />
  </fieldset>
  
</form>
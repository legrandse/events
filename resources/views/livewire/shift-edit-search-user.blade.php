<div>
   
                    <select wire:ignore="userSelected" name="user_id" class="form-select" id="select_box">
                        
                       <option value="">{{__('List')}}</option>
                       <option value="0">{{__('Empty')}}</option>
                        @foreach($users as $user)
                        
                            <option value="{{$user->id}}" wire:key="{{$user->id}}" {{$user->id == $userSelected ? 'selected' : ''}}>{{$user->name.' '.$user->firstname}}</option>';
                        @endforeach
                         
                    </select>
                

</div>

<script>
	 var select_box_element = document.querySelector('#select_box');

    dselect(select_box_element, {
        search: true
    });
</script>

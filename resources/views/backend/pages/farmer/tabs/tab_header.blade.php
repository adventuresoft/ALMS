<h3 class="card-title">
   <a href="{{ isset($user->id) ? route('farmer.edit', $user->id) : '#'}}">           <span class="{{$active_tab == 'personal' ? 'text-light' : 'text-dark'}}">Personal</span>        </a> <span class="text-secondary">|</span>
   <a href="{{ isset($user->id) ? route('farmer.family', $user->id) : '#'}}">         <span class="{{$active_tab == 'family' ? 'text-light' : 'text-dark'}}">Family</span>            </a> <span class="text-secondary">|</span>
   <a href="{{ isset($user->id) ? route('farmer.address', $user->id) : '#'}}">        <span class="{{$active_tab == 'address' ? 'text-light' : 'text-dark'}}">Address</span>          </a> <span class="text-secondary">|</span>
   <a href="{{ isset($user->id) ? route('farmer.cultivation', $user->id) : '#'}}">    <span class="{{$active_tab == 'cultivation' ? 'text-light' : 'text-dark'}}">Cultivation</span>  </a> <span class="text-secondary">|</span>
   <a href="{{ isset($user->id) ? route('farmer.land', $user->id) : '#'}}">    <span class="{{$active_tab == 'land' ? 'text-light' : 'text-dark'}}">Land Info</span>  </a> <span class="text-secondary">|</span>

   <a href="{{ isset($user->id) ? route('farmer.classification', $user->id) : '#'}}"> <span class="{{$active_tab == 'classification' ? 'text-light' : 'text-dark'}}">Initial Loan Info</span></a> <span class="text-secondary">|</span>
   <a href="{{ isset($user->id) ? route('approval.edit', $user->id) : '#'}}"> <span class="{{$active_tab == 'approval' ? 'text-light' : 'text-dark'}}">Approval</span></a> <span class="text-secondary"></span>

   {{-- <a href="{{ isset($user->id) ? route('farmer.education', $user->id) : '#'}}">      <span class="{{$active_tab == 'education' ? 'text-light' : 'text-dark'}}">Education</span>      </a> <span class="text-secondary">|</span>
   <a href="{{ isset($user->id) ? route('farmer.property', $user->id) : '#'}}">       <span class="{{$active_tab == 'property' ? 'text-light' : 'text-dark'}}">Property</span>        </a> <span class="text-secondary">|</span>
   <a href="{{ isset($user->id) ? route('farmer.disability', $user->id) : '#'}}">     <span class="{{$active_tab == 'disability' ? 'text-light' : 'text-dark'}}">Disability</span>    </a> <span class="text-secondary">|</span>
   <a href="{{ isset($user->id) ? route('farmer.freedom', $user->id) : '#'}}">        <span class="{{$active_tab == 'freedom' ? 'text-light' : 'text-dark'}}">Freedom Fighter</span>  </a> <span class="text-secondary">|</span> --}}
</h3>

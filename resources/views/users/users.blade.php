
<head>

</head>

<table style="width:60%">
  <tr>
    <th>Image</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone<th>
    <th>Accept<th>
  </tr>
  @foreach($users as $user)
  <tr>
     @if($user->profile_photo)
    <td>
      <img src="{{asset('/img/profiles/'.$user->profile_photo)}}" style="width:30px;height:30px;"> 
    </td>
     @else
     <td>
      <img src="{{asset('/img/profiles/male.jpg')}}" style="width:30px;height:30px;">  
   </td>
    @endif
    <td>{{$user->name}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->phone}}</td>
    <td> <button type="submit" class="btn btn-xs btn-danger">Accept</button> </td>
  </tr>
  @endforeach
</table>


<!-- Search Box -->
<div class="">
  <input type="text" id="taskSearch" class="form-control" placeholder="🔍 Search tasks...">
</div>

<!-- Task List -->
<ul id="taskList" class="list-group list-group-flush">
  @foreach ($list as $item)
    <li class="list-group-item d-flex justify-content-between align-items-start task-item ">
      <div class="flex-grow-1">
        <div class="task-title">{{ $item->task->title }}</div>
        <div class="task-date">{{ date_human_readable($item->created_at) }}</div>
        <img class="rounded-circle" data-user-id="{{$item->assignee->id}}" onclick="hr_show_employee_card(this)"
                                        src="{{ $item->assignee->avatar() }}"
                                        style="width: 25px; height: 25px;margin-right:5px;margin-bottom:5px;cursor: pointer;float:right"
                                        title="{{ $item->assignee->name }}">
      </div>
    </li>
  @endforeach
</ul>

<!-- Search Script -->
<script>
$(document).ready(function () {
  $('#taskSearch').on('keyup', function () {
    const value = $(this).val().toLowerCase();

    $('#taskList li').each(function () {
      const title = $(this).find('.task-title').text().toLowerCase();
        if (title.includes(value)) {
         $(this).css("background",'lightblue');
      } else {
        console.log($(this));

        $(this).css("background",'white');
      }
      if(value=='')
      {
 $(this).css("background",'white');
      }

    });
  });
});

</script>

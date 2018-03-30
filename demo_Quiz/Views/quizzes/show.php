@extends('admin.layout.show')

@section('show')
	<div class="panel panel-default">
		<div class="panel-heading">Основные параметры</div>
		<table class="table">
			<tr>
				<th>Тэги</th>
				<th>Сложность</th>
				<th>Slug</th>
				<th>Размер картинки</th>
				<th>Открыт</th>
				<th>Активен</th>
				<th>Считаются правильные ответы</th>
				<th>Вознаграждение</th>
				@if($item->isFixed())<th>Неткоины за квиз</th>@endif
			</tr>
			<tr>
				<td>{{ implode(', ', $item->tags->pluck('name')->toArray()) }}</td>
				<td>{{ $item->getLevelName() }}</td>
				<td>{{ $item->slug }}</td>
				<td>{{ $item->isDouble() ? 'Двойной' : 'Обычный' }}</td>
				<td>{!! $item->isOpened() ? '<span class="glyphicon glyphicon-ok"></span>' : '' !!}</td>
				<td>{!! $item->isActive() ? '<span class="glyphicon glyphicon-ok"></span>' : '' !!}</td>
				<td>{!! $item->withRightAnswers() ? '<span class="glyphicon glyphicon-ok"></span>' : '' !!}</td>
				<td>{{ $item->isFixed() ? 'Фиксированное' : 'На основе полученных баллов' }}</td>
				@if($item->isFixed())<td>{{ $item->points }}<i class="fa fa-" aria-hidden="true"></i></td>@endif
			</tr>
		</table>
		<div class="container">
			@if(isset($item->image) || isset($item->background))
				<div class="col-lg-2">
					<h3>Картинка:</h3>
				</div>
				<div class="col-lg-4">
					@isset($item->image)
						<a href="{{Storage::url($item->image)}}" target="_blank">
							<img src="{{Storage::url($item->image)}}" class="img-thumbnail" width="150">
						</a>
					@endisset
				</div>
				<div class="col-lg-2">
					<h3>Фон:</h3>
				</div>
				<div class="col-lg-4">
					@isset($item->background)
						<a href="{{Storage::url($item->background)}}" target="_blank">
							<img src="{{Storage::url($item->background)}}" class="img-thumbnail" width="150">
						</a>
					@endisset
				</div>
			@else
				<hr>
			@endif
		</div>
		<div class="panel-heading row header">Вопросы
			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group">
					<a href="{{ route(question_settings('admin_route_prefix') . '.create', $item) }}"
					   class="btn btn-primary">Добавить {{ mb_strtolower(question_settings('name')) }}</a>
				</div>
			</div>
		</div>
		@foreach($item->questions as $question)
			<div class="panel-heading row header">
				<b>№{{ $question->sort }} {{ strip_tags($question->description) }}</b>
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group">
						<a class="btn btn-info"
						   href="{{ route(question_settings('admin_route_prefix') . '.edit', [$question->quiz_id, $question->id]) }}">
							<i class="glyphicon glyphicon-pencil"></i>
						</a>
						<a class="btn btn-primary"
						   href="{{ route(answer_settings('admin_route_prefix') . '.create', [$question->quiz_id, $question->id]) }}">
							Добавить {{ mb_strtolower(answer_settings('name')) }}
						</a>
					</div>
				</div>
			</div>
			<ul class="list-group">
				@foreach($question->answers as $answer)
					<li class="list-group-item">
						<div class="row header">
							@if($item->withRightAnswers())
								@if($answer->isCorrect())
									<span class="glyphicon glyphicon-ok" style="color:green"></span>
								@else
									<span class="glyphicon glyphicon-remove" style="color:red"></span>
								@endif
							@endif
							@isset($answer->points)
								<span class="badge">{{ $answer->points }} <i class="fa fa-"></i></span>
							@endisset
							{{ $answer->title }}
							<div class="btn-toolbar" role="toolbar">
								<div class="btn-group">
									<a class="btn btn-info"
									   href="{{ route(answer_settings('admin_route_prefix') . '.edit', [$question->quiz_id, $question->id, $answer->id]) }}">
										<i class="glyphicon glyphicon-pencil"></i>
									</a>
								</div>
							</div>
						</div>
					</li>
				@endforeach
			</ul>
		@endforeach

		<div class="panel-heading row header">Финальные экраны
			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group">
					<a href="{{ route(final_screen_settings('admin_route_prefix') . '.create', $item) }}"
					   class="btn btn-primary">Добавить {{ mb_strtolower(final_screen_settings('name')) }}</a>
				</div>
			</div>
		</div>
		@isset($item->finalScreens)
		<ul class="list-group">
			@foreach($item->finalScreens as $finalScreen)
				<li class="list-group-item">
					<div class="row header">
						<b> {{ $finalScreen->id }}.  {{ $finalScreen->name }}</b>
						<span class="badge">{{ $finalScreen->min_points or '0' }} -
							@if(!is_null($finalScreen->max_points))
								{{ $finalScreen->max_points }}
							@else
								&#8734;
							@endif
						</span>
						<div class="btn-toolbar" role="toolbar">
							<div class="btn-group">
								<a class="btn btn-info"
								   href="{{ route(final_screen_settings('admin_route_prefix') . '.edit', [$finalScreen->quiz, $finalScreen->id]) }}">
									<i class="glyphicon glyphicon-pencil"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="container">
						@if(isset($finalScreen->image))
							<div class="col-lg-4">
								@isset($finalScreen->image)
									<img src="{{Storage::url($finalScreen->image)}}" class="img-thumbnail" width="150">
								@endisset
							</div>
						@else
							<hr>
						@endif
					</div>

					<div class="card-body">
						<h3><b>{{ $finalScreen->name }}</b></h3>
						<h6 class="card-title">
							{!! $finalScreen->description !!}
							<p>Поделиться результатом:</p>
							<a href="{{ fbShareLink(route('final_screen', $finalScreen->id)) }}" data-analytics="fb" target="_blank">
								<div class="fb-sharer"><span data-fb-shares class="fb-share-counter">...</span></div>
							</a>
							<a href="{{ vkShareLink(route('final_screen', $finalScreen->id)) }}" data-analytics="vk" target="_blank">
								<div class="vk-sharer"><span data-vk-shares class="vk-share-counter">...</span></div>
							</a>
						</h6>
					</div>

				</li>
			@endforeach
		</ul>
		@endisset
	</div>
@endsection

@section('buttons-panel')
	<a href="{{ route($settings['admin_route_prefix'] . '.edit', $item->id) }}" class="btn btn-primary">Редактировать</a>
@endsection
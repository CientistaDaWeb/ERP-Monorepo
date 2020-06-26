<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait ApiControllerTrait
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $limit = $request->all()['limit'] ?? 10;
    if($limit == 0){
      $limit = 100000;
    }

    $order = $request->all()['order'] ?? null;
    if ($order !== null) {
      $order = explode(',', $order);
    }
    $order[0] = $order[0] ?? 'id';
    $order[1] = $order[1] ?? 'asc';

    $where = $request->all()['where'] ?? [];
    $whereHas = $request->all()['whereHas'] ?? [];

    $filter = $request->all()['filter'] ?? [];

    $like = $request->all()['like'] ?? null;
    if ($like) {
      $like = explode(',', $like);
      $like[1] = '%' . $like[1] . '%';
    }
    $result =
      $this->model->orderBy($order[0], $order[1])
        ->where(function ($query) use ($like) {
          if ($like) {
            $query->where($like[0], 'like', $like[1]);
          }
        })
        ->where(function ($query) use ($filter) {
          if ($filter && isset($this->model->filters)) {
            $textWord = $filter;
            $texts = explode(';', $textWord);
            foreach ($this->model->filters as $filter) {
              foreach ($texts as $text) {
                $subquery = strpos($filter['column'], '.');
                if ($filter['type'] == 'like') {
                  $text = '%' . $text . '%';
                }
                if ($subquery === false) {
                  $query->orWhere($filter['column'], $filter['type'], $text);
                } else {
                  $table = explode('.', $filter['column']);
                  $query->orWhereHas($table[0], function ($query) use ($table, $text, $filter) {
                    $query->where($table[1], $filter['type'], $text);
                  });
                }
              }
            }
          }
        })
        ->where($where)
        ->where(function ($query) use ($whereHas) {
          if ($whereHas) {
            foreach ($whereHas AS $index => $fields) {
              $query->whereHas($index, function ($query2) use ($fields) {
                foreach ($fields AS $field => $value) {
                  $query2->where($field, $value);
                }
              });
            }
          }
        })
        ->with($this->relationships())
        ->paginate($limit);

    return response()->json($result);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $result = $this->model->create($request->all());
    return response()->json($result);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $result = $this->model->with($this->relationships())
      ->findOrFail($id);
    if (isset($this->model->showAttributes)) {
      foreach ($this->model->showAttributes as $attribute) {
        $result->$attribute = $result->$attribute;
      }
    }
    return response()->json($result);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $result = $this->model->findOrFail($id);
    $result->update($request->all());
    return response()->json($result);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $result = $this->model->findOrFail($id);
    $result->delete();
    return response()->json($result);
  }

  protected function relationships()
  {
    if (isset($this->relationships)) {
      return $this->relationships;
    }
    return [];
  }
}

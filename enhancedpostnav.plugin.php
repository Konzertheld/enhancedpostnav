<?php
namespace Habari;

class EnhancedPostNav extends Plugin
{
	public function filter_template_where_filters($where_filters)
	{
		$posts = Posts::get($where_filters);
		if(count($posts) > 1) {
			// this is a bit hacky, ok, but it makes sure we don't mess up if we already are in single view
			$data = Session::get_set('ascdesc', true);
			Session::add_to_set('ascdesc', $where_filters, 'lastmultiple');
		}
		return $where_filters;
	}
	
	public function filter_ascend_filters($filters)
	{
		$data = Session::get_set('ascdesc', false);
		if(isset($data['lastmultiple'])) {
			return array_merge($data['lastmultiple']->getArrayCopy(), array('orderby' => 'pubdate ASC', 'nolimit' => 1));
		}
		else {
			return $filters;
		}
	}
	
	public function filter_descend_filters($filters)
	{	
		$data = Session::get_set('ascdesc', false);
		if(isset($data['lastmultiple'])) {
			return array_merge($data['lastmultiple']->getArrayCopy(), array('orderby' => 'pubdate DESC', 'nolimit' => 1));
		}
		else {
			return $filters;
		}
	}
}
?>
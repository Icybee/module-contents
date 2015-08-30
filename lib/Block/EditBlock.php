<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Contents\Block;

use Brickrouge\Element;
use Brickrouge\Form;
use Brickrouge\Text;

use Icybee\Modules\Contents\Content;
use Icybee\Modules\Editor\MultiEditorElement;

class EditBlock extends \Icybee\Modules\Nodes\Block\EditBlock
{
	protected function lazy_get_attributes()
	{
		$attributes = parent::lazy_get_attributes();

		$attributes[Element::GROUPS] = array_merge($attributes[Element::GROUPS], [

			'contents' => [ 'title' => 'Content' ],
			'date' => []

		]);

		return $attributes;
	}

	protected function lazy_get_children()
	{
		$app = $this->app;
		$metas = $app->site->metas;
		$module_flat_id = $this->module->flat_id;
		$default_editor = $metas[$module_flat_id . '.default_editor'] ?: 'rte';
		$use_multi_editor = $metas[$module_flat_id . '.use_multi_editor'];

		if ($use_multi_editor)
		{

		}
		else
		{

		}

		$values = $this->values;

		return array_merge(parent::lazy_get_children(), [

			Content::SUBTITLE => new Text([

				Form::LABEL => 'subtitle'
			]),

			Content::BODY => new MultiEditorElement
			(
				$values['editor'] ? $values['editor'] : $default_editor, [

					Element::LABEL_MISSING => 'Contents',
					Element::GROUP => 'contents',
					Element::REQUIRED => true,

					'rows' => 16
				]
			),

			Content::EXCERPT => $app->editors['rte']->from([

				Form::LABEL => 'excerpt',
				Element::GROUP => 'contents',
				Element::DESCRIPTION => "excerpt",

				'rows' => 3
			]),

			Content::DATE => new \Brickrouge\Date([

				Form::LABEL => 'Date',
				Element::REQUIRED => true,
				Element::DEFAULT_VALUE => date('Y-m-d')
			]),

			Content::IS_HOME_EXCLUDED => new Element(Element::TYPE_CHECKBOX, [

				Element::LABEL => "is_home_excluded",
				Element::GROUP => 'visibility',
				Element::DESCRIPTION => "is_home_excluded"
			])
		]);
	}

	protected function lazy_get_values()
	{
		$values = parent::lazy_get_values();

		if (isset($values['editor']) && isset($values['body']))
		{
			$editor = $this->app->editors[$values['editor']];

			$values['body'] = $editor->unserialize($values['body']);
		}

		return $values;
	}
}

<?php
/* This file has been auto-generated. Do not edit this file directly. */

abstract class Sabai_Addon_Comment_Model_Base_PostGateway extends SabaiFramework_Model_Gateway
{
    public function getName()
    {
        return 'comment_post';
    }

    public function getFields()
    {
        return array('post_body' => SabaiFramework_Model::KEY_TYPE_TEXT, 'post_body_html' => SabaiFramework_Model::KEY_TYPE_TEXT, 'post_entity_id' => SabaiFramework_Model::KEY_TYPE_INT, 'post_entity_bundle_id' => SabaiFramework_Model::KEY_TYPE_INT, 'post_published_at' => SabaiFramework_Model::KEY_TYPE_INT, 'post_status' => SabaiFramework_Model::KEY_TYPE_INT, 'post_vote_sum' => SabaiFramework_Model::KEY_TYPE_INT, 'post_vote_count' => SabaiFramework_Model::KEY_TYPE_INT, 'post_flag_sum' => SabaiFramework_Model::KEY_TYPE_INT, 'post_flag_count' => SabaiFramework_Model::KEY_TYPE_INT, 'post_edit_count' => SabaiFramework_Model::KEY_TYPE_INT, 'post_edit_last_at' => SabaiFramework_Model::KEY_TYPE_INT, 'post_edit_last_by' => SabaiFramework_Model::KEY_TYPE_INT, 'post_edit_last_reason' => SabaiFramework_Model::KEY_TYPE_VARCHAR, 'post_hidden_at' => SabaiFramework_Model::KEY_TYPE_INT, 'post_hidden_by' => SabaiFramework_Model::KEY_TYPE_INT, 'post_vote_disabled' => SabaiFramework_Model::KEY_TYPE_BOOL, 'post_flag_disabled' => SabaiFramework_Model::KEY_TYPE_BOOL, 'post_id' => SabaiFramework_Model::KEY_TYPE_INT, 'post_created' => SabaiFramework_Model::KEY_TYPE_INT, 'post_updated' => SabaiFramework_Model::KEY_TYPE_INT, 'post_user_id' => SabaiFramework_Model::KEY_TYPE_INT);
    }

    protected function _getIdFieldName()
    {
        return 'post_id';
    }

    protected function _getSelectByIdQuery($id, $fields)
    {
        return sprintf(
            'SELECT %s FROM %scomment_post WHERE post_id = %d',
            empty($fields) ? '*' : implode(', ', $fields),
            $this->_db->getResourcePrefix(),
            $id
        );
    }

    protected function _getSelectByIdsQuery($ids, $fields)
    {
        return sprintf(
            'SELECT %s FROM %scomment_post WHERE post_id IN (%s)',
            empty($fields) ? '*' : implode(', ', $fields),
            $this->_db->getResourcePrefix(),
            implode(', ', array_map('intval', $ids))
        );
    }

    protected function _getSelectByCriteriaQuery($criteriaStr, $fields)
    {
        return sprintf(
            'SELECT %1$s FROM %2$scomment_post comment_post WHERE %3$s',
            empty($fields) ? '*' : implode(', ', $fields),
            $this->_db->getResourcePrefix(),
            $criteriaStr
        );
    }

    protected function _getInsertQuery(&$values)
    {
        $values['post_created'] = time();
        $values['post_updated'] = 0;
        return sprintf('INSERT INTO %scomment_post(post_body, post_body_html, post_entity_id, post_entity_bundle_id, post_published_at, post_status, post_vote_sum, post_vote_count, post_flag_sum, post_flag_count, post_edit_count, post_edit_last_at, post_edit_last_by, post_edit_last_reason, post_hidden_at, post_hidden_by, post_vote_disabled, post_flag_disabled, post_id, post_created, post_updated, post_user_id) VALUES(%s, %s, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %s, %d, %d, %u, %u, %s, %d, %d, %d)', $this->_db->getResourcePrefix(), $this->_db->escapeString($values['post_body']), $this->_db->escapeString($values['post_body_html']), $values['post_entity_id'], $values['post_entity_bundle_id'], $values['post_published_at'], $values['post_status'], $values['post_vote_sum'], $values['post_vote_count'], $values['post_flag_sum'], $values['post_flag_count'], $values['post_edit_count'], $values['post_edit_last_at'], $values['post_edit_last_by'], $this->_db->escapeString($values['post_edit_last_reason']), $values['post_hidden_at'], $values['post_hidden_by'], $this->_db->escapeBool($values['post_vote_disabled']), $this->_db->escapeBool($values['post_flag_disabled']), empty($values['post_id']) ? 'NULL' : intval($values['post_id']), $values['post_created'], $values['post_updated'], $values['post_user_id']);
    }

    protected function _getUpdateQuery($id, $values)
    {
        $last_update = $values['post_updated'];
        $values['post_updated'] = time();
        return sprintf('UPDATE %scomment_post SET post_body = %s, post_body_html = %s, post_entity_id = %d, post_entity_bundle_id = %d, post_published_at = %d, post_status = %d, post_vote_sum = %d, post_vote_count = %d, post_flag_sum = %d, post_flag_count = %d, post_edit_count = %d, post_edit_last_at = %d, post_edit_last_by = %d, post_edit_last_reason = %s, post_hidden_at = %d, post_hidden_by = %d, post_vote_disabled = %u, post_flag_disabled = %u, post_updated = %d, post_user_id = %d WHERE post_id = %d AND post_updated = %d', $this->_db->getResourcePrefix(), $this->_db->escapeString($values['post_body']), $this->_db->escapeString($values['post_body_html']), $values['post_entity_id'], $values['post_entity_bundle_id'], $values['post_published_at'], $values['post_status'], $values['post_vote_sum'], $values['post_vote_count'], $values['post_flag_sum'], $values['post_flag_count'], $values['post_edit_count'], $values['post_edit_last_at'], $values['post_edit_last_by'], $this->_db->escapeString($values['post_edit_last_reason']), $values['post_hidden_at'], $values['post_hidden_by'], $this->_db->escapeBool($values['post_vote_disabled']), $this->_db->escapeBool($values['post_flag_disabled']), $values['post_updated'], $values['post_user_id'], $id, $last_update);
    }

    protected function _getDeleteQuery($id)
    {
        return sprintf('DELETE FROM %1$scomment_post WHERE post_id = %2$d', $this->_db->getResourcePrefix(), $id);
    }

    protected function _getUpdateByCriteriaQuery($criteriaStr, $sets)
    {
        $sets['post_updated'] = 'post_updated=' . time();
        return sprintf('UPDATE %scomment_post comment_post SET %s WHERE %s', $this->_db->getResourcePrefix(), implode(', ', $sets), $criteriaStr);
    }

    protected function _getDeleteByCriteriaQuery($criteriaStr)
    {
        return sprintf('DELETE comment_post, table1 FROM %1$scomment_post comment_post LEFT JOIN %1$scomment_vote table1 ON comment_post.post_id = table1.vote_post_id WHERE %2$s', $this->_db->getResourcePrefix(), $criteriaStr);
    }

    protected function _getCountByCriteriaQuery($criteriaStr)
    {
        return sprintf('SELECT COUNT(*) FROM %1$scomment_post comment_post WHERE %2$s', $this->_db->getResourcePrefix(), $criteriaStr);
    }

    protected function _beforeDelete1($id, array $old)
    {
        $this->_db->exec(sprintf('DELETE table0 FROM %1$scomment_vote table0 WHERE table0.vote_post_id = %2$d', $this->_db->getResourcePrefix(), $id));
    }

    protected function _beforeDelete($id, array $old)
    {
        $this->_beforeDelete1($id, $old);
    }
}
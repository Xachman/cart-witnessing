<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EmailAttachments Controller
 *
 * @property \App\Model\Table\EmailAttachmentsTable $EmailAttachments
 */
class EmailAttachmentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Emails']
        ];
        $emailAttachments = $this->paginate($this->EmailAttachments);

        $this->set(compact('emailAttachments'));
        $this->set('_serialize', ['emailAttachments']);
    }

    /**
     * View method
     *
     * @param string|null $id Email Attachment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailAttachment = $this->EmailAttachments->get($id, [
            'contain' => ['Emails']
        ]);

        $this->set('emailAttachment', $emailAttachment);
        $this->set('_serialize', ['emailAttachment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailAttachment = $this->EmailAttachments->newEntity();
        if ($this->request->is('post')) {
            $emailAttachment = $this->EmailAttachments->patchEntity($emailAttachment, $this->request->data);
            if ($this->EmailAttachments->save($emailAttachment)) {
                $this->Flash->success(__('The email attachment has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The email attachment could not be saved. Please, try again.'));
            }
        }
        $emails = $this->EmailAttachments->Emails->find('list', ['limit' => 200]);
        $this->set(compact('emailAttachment', 'emails'));
        $this->set('_serialize', ['emailAttachment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Attachment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailAttachment = $this->EmailAttachments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailAttachment = $this->EmailAttachments->patchEntity($emailAttachment, $this->request->data);
            if ($this->EmailAttachments->save($emailAttachment)) {
                $this->Flash->success(__('The email attachment has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The email attachment could not be saved. Please, try again.'));
            }
        }
        $emails = $this->EmailAttachments->Emails->find('list', ['limit' => 200]);
        $this->set(compact('emailAttachment', 'emails'));
        $this->set('_serialize', ['emailAttachment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Email Attachment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailAttachment = $this->EmailAttachments->get($id);
        if ($this->EmailAttachments->delete($emailAttachment)) {
            $this->Flash->success(__('The email attachment has been deleted.'));
        } else {
            $this->Flash->error(__('The email attachment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

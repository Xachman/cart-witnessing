<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Outcomes Controller
 *
 * @property \App\Model\Table\OutcomesTable $Outcomes
 */
class OutcomesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Locations']
        ];
        $outcomes = $this->paginate($this->Outcomes);

        $this->set(compact('outcomes'));
        $this->set('_serialize', ['outcomes']);
    }

    /**
     * View method
     *
     * @param string|null $id Outcome id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $outcome = $this->Outcomes->get($id, [
            'contain' => ['Locations']
        ]);

        $this->set('outcome', $outcome);
        $this->set('_serialize', ['outcome']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $outcome = $this->Outcomes->newEntity();
        if ($this->request->is('post')) {
            $outcome = $this->Outcomes->patchEntity($outcome, $this->request->data);
            if ($this->Outcomes->save($outcome)) {
                $this->Flash->success(__('The outcome has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The outcome could not be saved. Please, try again.'));
            }
        }
        $locations = $this->Outcomes->Locations->find('list', ['limit' => 200]);
        $this->set(compact('outcome', 'locations'));
        $this->set('_serialize', ['outcome']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Outcome id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $outcome = $this->Outcomes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outcome = $this->Outcomes->patchEntity($outcome, $this->request->data);
            if ($this->Outcomes->save($outcome)) {
                $this->Flash->success(__('The outcome has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The outcome could not be saved. Please, try again.'));
            }
        }
        $locations = $this->Outcomes->Locations->find('list', ['limit' => 200]);
        $this->set(compact('outcome', 'locations'));
        $this->set('_serialize', ['outcome']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Outcome id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $outcome = $this->Outcomes->get($id);
        if ($this->Outcomes->delete($outcome)) {
            $this->Flash->success(__('The outcome has been deleted.'));
        } else {
            $this->Flash->error(__('The outcome could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

      <div class="row featurette">
        <div class="col-md-6">
          <p class="lead">The "Tesla Collection" is the most comprehensive compilation of newspaper and periodical material ever assembled by or about Nikola Tesla.  The Collection begins on August 14, 1886 and continues through December 11, 1920.  Comprising approximately 1,700 separate items totaling more than 4,200 pages, the Collection is drawn from both American and British publications and is reproduced directly from the original English Language material.</p>
        </div>
        <div class="col-md-6">
          <p class="lead">Seen together "The Tesla Collection" not only sheds new light on the early days of electricity, and the development and widespread acceptance by the public and scientific community of Alternating Current, but also provides a one-of-a-kind look into the early days of X-Ray, Wireless, Remote Control, Robotics and the efforts and experiments made by Tesla into the development and delivery of wireless Electricity.</p>
        </div>
      </div>
      
      <div class="row featurette">
        <div class="col-md-12" style="text-align:center; margin: 15px">
          <blockquote>When citing from this web site the following citation format should be used:<br/> <em>Rudinska, Iwona. Editor "The Tesla Collection." Original Article Author, "Article Title." Publication Publication Date: Page(s). (http://www.teslacollection.com)</em></blockquote>
        </div>
      </div>
      
      <div class="row featurette">
        <div class="col-md-12">
          <h2 class="" style="text-align: center">Article Search</h2>
        </div>
      </div>

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-sm-3">
          <?php 
          echo $this->element('selection', array(
          		'selection_id' => 'publication_id'
          		, 'id' => 'publication_selection'
          		, 'selection_name' => 'Publication'
          		, 'options' => $selections['publication']
          ));
		  ?>
        </div>
        <div class="col-sm-3">
        <?php
				echo $this->element('selection', array(
			   		'selection_id' => 'author_id'
			   		, 'id' => 'author_selection'
			   		, 'selection_name' => 'Author'
			   		, 'options' => $selections['author']
				));
        ?>
       </div>
        <div class="col-sm-3">
        <?php
				echo $this->element('selection', array(
			   		'selection_id' => 'year_id'
			   		, 'id' => 'year_selection'
			   		, 'selection_name' => 'Year'
			   		, 'options' => $selections['year']
				));
        ?>   
       </div>
        <div class="col-sm-3">
                <?php
				echo $this->element('selection', array(
			   		'selection_id' => 'subject_id'
			   		, 'id' => 'subject_selection'
			   		, 'selection_name' => 'Subject'
			   		, 'options' => $selections['subject']
				));
        ?>   
        </div>
      </div><!-- /.row -->
      
      <div class="row" style="text-align: center; margin: 20px 0px">
      	<p><a class="btn btn-default" href="#" role="button">Search &raquo;</a><a class="btn btn-default" href="#" role="button">Reset &raquo;</a></p>
      </div>